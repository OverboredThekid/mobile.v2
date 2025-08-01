<?php

namespace App\Traits;

use App\Services\ApiService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

trait ApiControllerTrait
{
    /**
     * Configuration for the API controller
     * Override these in your controller
     */
    protected function getApiConfig(): array
    {
        return [
            'model' => null, // Eloquent model class
            'dto' => null, // DTO class for data transfer
            'base_endpoint' => '', // Base API endpoint
            'count_endpoint' => '', // Count endpoint (optional)
            'meta_endpoint' => '', // Meta endpoint (optional)
            'cache_prefix' => '', // Cache prefix for this model
            'default_filters' => [], // Default filters for queries
            'json_fields' => [], // Fields that should be decoded from JSON
            'scope_methods' => [], // Available scope methods on the model
            'use_team_id' => true, // Whether to use team ID in endpoints
        ];
    }

    /**
     * Get paginated data with caching and ETag support
     */
    public function getPaginatedData(string $filter = 'all', int $page = 1, int $perPage = 10, array $customFilters = []): array
    {
        $config = $this->getApiConfig();
        $modelClass = $config['model'];
        $dtoClass = $config['dto'];
        $baseEndpoint = $config['base_endpoint'];
        $cachePrefix = $config['cache_prefix'];
        $jsonFields = $config['json_fields'] ?? [];
        $useTeamId = $config['use_team_id'] ?? true;

        try {
            $api = new ApiService();
            $etagKey = "{$cachePrefix}.{$filter}.etag";
            $localEtag = Cache::get($etagKey);
            
            // Build meta endpoint
            $metaEndpoint = $this->buildMetaEndpoint($baseEndpoint, $filter, $customFilters);
            $meta = $api->get($metaEndpoint, $useTeamId);
            $meta = is_array($meta) ? $meta : (array) $meta;

            $isStale = ($meta['etag'] ?? null) !== $localEtag;

            if ($isStale) {
                // Build data endpoint
                $dataEndpoint = $this->buildDataEndpoint($baseEndpoint, $filter, $page, $perPage, $customFilters);
                $response = $api->get($dataEndpoint, $useTeamId);
                $response = is_array($response) ? $response : (array) $response;
                
                // Handle different response structures
                $data = $response;
                Log::info("{$cachePrefix} API response keys: " . implode(', ', array_keys($response)));
                if (isset($response['data'])) {
                    // Response has 'data' key (like shifts API)
                    $data = $response['data'];
                    Log::info("{$cachePrefix} extracted data from 'data' key: " . count($data) . " items");
                } elseif (isset($response['links']) && isset($response['meta'])) {
                    // Response has pagination structure (like shift-requests API)
                    $data = $response['data'] ?? [];
                    Log::info("{$cachePrefix} extracted data from paginated response: " . count($data) . " items");
                }
                
                if (is_array($data)) {
                    Log::info("Processing {$cachePrefix} data: " . count($data) . " items");
                    foreach ($data as $item) {
                        $item = is_array($item) ? $item : (array) $item;
                        try {
                            $dto = $dtoClass::fromApiResponse($item);
                            $dtoArray = $dto->toArray();
                            
                            $modelClass::updateOrCreate(
                                ['api_id' => $dto->id],
                                array_merge($dtoArray, [
                                    'etag' => $meta['etag'] ?? null,
                                    'fetched_at' => now(),
                                ])
                            );
                            Log::info("Successfully processed {$cachePrefix} item: " . $dto->id);
                        } catch (\Exception $e) {
                            Log::error("Failed to process {$cachePrefix} item: " . $e->getMessage());
                        }
                    }
                } else {
                    Log::warning("{$cachePrefix} data is not an array: " . gettype($data));
                }

                Cache::put($etagKey, $meta['etag'] ?? null);
            }

            // Apply filters to local data
            $query = $this->buildLocalQuery($modelClass, $filter, $customFilters);
            
            // Apply pagination
            $results = $query->orderBy('start_time', 'asc')
                            ->skip(($page - 1) * $perPage)
                            ->take($perPage)
                            ->get();
            
            // Convert to array and decode JSON fields
            return $this->convertToArray($results, $jsonFields);
        } catch (\Throwable $e) {
            Log::error("{$cachePrefix} sync failed: " . $e->getMessage());

            // Fallback to local data
            $fallback = $this->buildLocalQuery($modelClass, $filter, $customFilters);
            $fallback = $fallback->orderBy('start_time', 'asc')
                                ->skip(($page - 1) * $perPage)
                                ->take($perPage)
                                ->get();
            
            return $this->convertToArray($fallback, $jsonFields);
        }
    }

    /**
     * Get count data with caching
     */
    public function getCountData(): array
    {
        $config = $this->getApiConfig();
        $countEndpoint = $config['count_endpoint'] ?? null;
        $cachePrefix = $config['cache_prefix'];
        $useTeamId = $config['use_team_id'] ?? true;

        if (!$countEndpoint) {
            return ['count' => 0];
        }

        try {
            $api = new ApiService();
            $etagKey = "{$cachePrefix}_count.etag";
            $countKey = "{$cachePrefix}_count.value";

            $meta = $api->get("{$countEndpoint}/meta", $useTeamId);
            $meta = is_array($meta) ? $meta : (array) $meta;
            $localEtag = Cache::get($etagKey);

            if ($localEtag !== ($meta['etag'] ?? null)) {
                $response = $api->get($countEndpoint, $useTeamId);
                $response = is_array($response) ? $response : (array) $response;
                $count = $response['count'] ?? 0;

                Cache::put($countKey, $count, now()->addMinutes(10));
                Cache::put($etagKey, $meta['etag'] ?? null, now()->addMinutes(10));

                return ['count' => $count];
            }

            return ['count' => Cache::get($countKey, 0)];
        } catch (\Throwable $e) {
            Log::error("{$cachePrefix} count failed: " . $e->getMessage());

            $fallback = Cache::get("{$cachePrefix}_count.value");
            return ['count' => $fallback ?? 0, 'fallback' => true];
        }
    }

    /**
     * Get individual item by ID
     */
    public function getItemById($id): array
    {
        $config = $this->getApiConfig();
        $modelClass = $config['model'];
        $dtoClass = $config['dto'];
        $baseEndpoint = $config['base_endpoint'];
        $cachePrefix = $config['cache_prefix'];
        $jsonFields = $config['json_fields'] ?? [];
        $useTeamId = $config['use_team_id'] ?? true;

        try {
            $api = new ApiService();
            $cacheKey = "{$cachePrefix}:{$id}";
            $local = $modelClass::where('api_id', $id)->first();

            $isStale = true;
            if ($local) {
                $meta = $api->get("{$baseEndpoint}/{$id}/meta", $useTeamId);
                $meta = is_array($meta) ? $meta : (array) $meta;
                $isStale = ($meta['etag'] ?? null) !== $local->etag;
            }

            if ($isStale) {
                $remote = $api->get("{$baseEndpoint}/{$id}", $useTeamId);
                $remote = is_array($remote) ? $remote : (array) $remote;
                $dto = $dtoClass::fromApiResponse($remote);

                $modelClass::updateOrCreate(
                    ['api_id' => $dto->id],
                    array_merge($dto->toArray(), [
                        'etag' => $remote['etag'] ?? $meta['etag'] ?? null,
                        'fetched_at' => now(),
                    ])
                );

                Cache::put($cacheKey, $remote, now()->addMinutes(10));
                return $remote;
            }

            $itemArray = $local->toArray();
            return Cache::remember($cacheKey, now()->addMinutes(10), fn () => $this->decodeJsonFields($itemArray, $jsonFields));
        } catch (\Throwable $e) {
            Log::error("{$cachePrefix} [ID $id] fetch failed: " . $e->getMessage());

            $fallback = $modelClass::where('api_id', $id)->first();
            if ($fallback) {
                $itemArray = $fallback->toArray();
                return $this->decodeJsonFields($itemArray, $jsonFields);
            }
            
            return [];
        }
    }

    /**
     * Get items by custom filter (e.g., by user, by venue)
     */
    public function getItemsByFilter(string $filterType, $filterValue, array $customFilters = []): array
    {
        $config = $this->getApiConfig();
        $modelClass = $config['model'];
        $dtoClass = $config['dto'];
        $baseEndpoint = $config['base_endpoint'];
        $cachePrefix = $config['cache_prefix'];
        $jsonFields = $config['json_fields'] ?? [];
        $useTeamId = $config['use_team_id'] ?? true;

        try {
            $api = new ApiService();
            $etagKey = "{$cachePrefix}_{$filterType}_{$filterValue}.etag";
            $localEtag = Cache::get($etagKey);
            
            $metaEndpoint = "{$baseEndpoint}/{$filterType}/{$filterValue}/meta";
            $meta = $api->get($metaEndpoint, $useTeamId);
            $meta = is_array($meta) ? $meta : (array) $meta;

            $isStale = ($meta['etag'] ?? null) !== $localEtag;

            if ($isStale) {
                $dataEndpoint = "{$baseEndpoint}/{$filterType}/{$filterValue}";
                $data = $api->get($dataEndpoint, $useTeamId);
                $data = is_array($data) ? $data : (array) $data;

                // Handle different response structures
                $items = $data;
                if (isset($data['data'])) {
                    // Response has 'data' key (like shifts API)
                    $items = $data['data'];
                } elseif (isset($data['links']) && isset($data['meta'])) {
                    // Response has pagination structure (like shift-requests API)
                    $items = $data['data'] ?? [];
                }

                foreach ($items as $item) {
                    $item = is_array($item) ? $item : (array) $item;
                    $dto = $dtoClass::fromApiResponse($item);
                    
                    $modelClass::updateOrCreate(
                        ['api_id' => $dto->id],
                        array_merge($dto->toArray(), [
                            'etag' => $meta['etag'] ?? null,
                            'fetched_at' => now(),
                        ])
                    );
                }

                Cache::put($etagKey, $meta['etag'] ?? null);
            }

            // Build local query with filter
            $query = $this->buildFilteredQuery($modelClass, $filterType, $filterValue, $customFilters);
            $results = $query->get();
            
            return $this->convertToArray($results, $jsonFields);
        } catch (\Throwable $e) {
            Log::error("{$cachePrefix} for {$filterType} {$filterValue} failed: " . $e->getMessage());

            $fallback = $this->buildFilteredQuery($modelClass, $filterType, $filterValue, $customFilters);
            $fallback = $fallback->get();
            
            return $this->convertToArray($fallback, $jsonFields);
        }
    }

    /**
     * Magic method to handle dynamic method calls
     */
    public function __call($method, $arguments)
    {
        $config = $this->getApiConfig();
        $scopeMethods = $config['scope_methods'] ?? [];

        // Handle scope-based methods
        if (str_starts_with($method, 'get') && str_ends_with($method, 'Data')) {
            $filter = strtolower(str_replace(['get', 'Data'], '', $method));
            return $this->getPaginatedData($filter, ...$arguments);
        }

        // Handle count methods
        if (str_starts_with($method, 'get') && str_ends_with($method, 'Count')) {
            return $this->getCountData();
        }

        // Handle individual item methods
        if (str_starts_with($method, 'get') && str_ends_with($method, 'ById')) {
            $id = $arguments[0] ?? null;
            return $this->getItemById($id);
        }

        // Handle filtered methods
        if (str_starts_with($method, 'get') && str_contains($method, 'By')) {
            $parts = explode('By', $method);
            $filterType = strtolower($parts[1] ?? '');
            $filterValue = $arguments[0] ?? null;
            $customFilters = $arguments[1] ?? [];
            return $this->getItemsByFilter($filterType, $filterValue, $customFilters);
        }

        // Handle scope-based queries
        if (in_array($method, $scopeMethods)) {
            $modelClass = $config['model'];
            $query = $modelClass::query();
            return $query->$method(...$arguments);
        }

        throw new \BadMethodCallException("Method {$method} not found");
    }

    /**
     * Build meta endpoint URL
     */
    protected function buildMetaEndpoint(string $baseEndpoint, string $filter, array $customFilters = []): string
    {
        $endpoint = $baseEndpoint . "/meta";
        
        // Add filter as query parameter, not path segment
        $params = [];
        if ($filter !== 'all') {
            $params['filter'] = $filter;
        }
        
        // Add custom filters
        if (!empty($customFilters)) {
            $params = array_merge($params, $customFilters);
        }
        
        // Build query string
        if (!empty($params)) {
            $queryParams = http_build_query($params);
            $endpoint .= "?{$queryParams}";
        }
        
        return $endpoint;
    }

    /**
     * Build data endpoint URL
     */
    protected function buildDataEndpoint(string $baseEndpoint, string $filter, int $page, int $perPage, array $customFilters = []): string
    {
        $endpoint = $baseEndpoint;
        
        // Add filter as query parameter, not path segment
        $params = [];
        if ($filter !== 'all') {
            $params['filter'] = $filter;
        }
        
        // Add pagination and custom filters
        $params = array_merge($params, $customFilters, [
            'per_page' => $perPage,
            'page' => $page,
        ]);
        
        $queryParams = http_build_query($params);
        return $endpoint . "?{$queryParams}";
    }

    /**
     * Build local query with filters
     */
    protected function buildLocalQuery(string $modelClass, string $filter, array $customFilters = []): Builder
    {
        $query = $modelClass::query();
        
        // Apply default filters
        $defaultFilters = $this->getApiConfig()['default_filters'] ?? [];
        foreach ($defaultFilters as $scope => $value) {
            if (method_exists($modelClass, 'scope' . ucfirst($scope))) {
                $query->$scope($value);
            }
        }
        
        // Apply filter-specific scopes
        if ($filter !== 'all' && method_exists($modelClass, 'scope' . ucfirst($filter))) {
            $query->$filter();
        }
        
        // Apply custom filters
        foreach ($customFilters as $scope => $value) {
            if (method_exists($modelClass, 'scope' . ucfirst($scope))) {
                $query->$scope($value);
            }
        }
        
        return $query;
    }

    /**
     * Build filtered query for specific filters
     */
    protected function buildFilteredQuery(string $modelClass, string $filterType, $filterValue, array $customFilters = []): Builder
    {
        $query = $modelClass::query();
        
        // Apply the specific filter
        $scopeMethod = 'by' . ucfirst($filterType);
        if (method_exists($modelClass, 'scope' . ucfirst($filterType))) {
            $query->$scopeMethod($filterValue);
        }
        
        // Apply custom filters
        foreach ($customFilters as $scope => $value) {
            if (method_exists($modelClass, 'scope' . ucfirst($scope))) {
                $query->$scope($value);
            }
        }
        
        return $query;
    }

    /**
     * Convert Eloquent collection to array and decode JSON fields
     */
    protected function convertToArray($collection, array $jsonFields = []): array
    {
        return $collection->map(function ($item) use ($jsonFields) {
            $itemArray = $item->toArray();
            return $this->decodeJsonFields($itemArray, $jsonFields);
        })->toArray();
    }

    /**
     * Decode JSON fields in an array
     */
    protected function decodeJsonFields(array $itemArray, array $jsonFields = []): array
    {
        foreach ($jsonFields as $field) {
            if (isset($itemArray[$field])) {
                $itemArray[$field] = json_decode($itemArray[$field], true) ?? [];
            }
        }
        
        return $itemArray;
    }
} 