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
            'related_data' => [], // Related data to resolve (e.g., ['venue' => VenuesApi::class, 'workers' => UsersApi::class])
            'has_pagination' => true, // Whether the API uses pagination
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
        $hasPagination = $config['has_pagination'] ?? true;

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
                $dataEndpoint = $this->buildDataEndpoint($baseEndpoint, $filter, $page, $perPage, $customFilters, $hasPagination);
                $response = $api->get($dataEndpoint, $useTeamId);
                $response = is_array($response) ? $response : (array) $response;
                
                // Handle different response structures
                $data = $response;
                Log::info("{$cachePrefix} API response keys: " . implode(', ', array_keys($response)));
                
                if ($hasPagination) {
                    if (isset($response['data'])) {
                        // Response has 'data' key (like shifts API)
                        $data = $response['data'];
                        Log::info("{$cachePrefix} extracted data from 'data' key: " . count($data) . " items");
                    } elseif (isset($response['links']) && isset($response['meta'])) {
                        // Response has pagination structure (like shift-requests API)
                        $data = $response['data'] ?? [];
                        Log::info("{$cachePrefix} extracted data from paginated response: " . count($data) . " items");
                    }
                } else {
                    // Non-paginated response - data is the direct array
                    $data = $response;
                    Log::info("{$cachePrefix} non-paginated response: " . count($data) . " items");
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
            
            if ($hasPagination) {
                // Apply pagination for paginated APIs
                $results = $query->orderBy('start_time', 'asc')
                                ->skip(($page - 1) * $perPage)
                                ->take($perPage)
                                ->get();
            } else {
                // Get all results for non-paginated APIs
                $results = $query->get();
            }
            
            // Convert to array and decode JSON fields
            return $this->convertToArray($results, $jsonFields);
        } catch (\Throwable $e) {
            Log::error("{$cachePrefix} sync failed: " . $e->getMessage());

            // Fallback to local data
            $fallback = $this->buildLocalQuery($modelClass, $filter, $customFilters);
            
            if ($hasPagination) {
                $fallback = $fallback->orderBy('start_time', 'asc')
                                    ->skip(($page - 1) * $perPage)
                                    ->take($perPage)
                                    ->get();
            } else {
                $fallback = $fallback->get();
            }
            
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
    protected function buildDataEndpoint(string $baseEndpoint, string $filter, int $page, int $perPage, array $customFilters = [], bool $hasPagination = true): string
    {
        $endpoint = $baseEndpoint;
        
        // Add filter as query parameter, not path segment
        $params = [];
        if ($filter !== 'all') {
            $params['filter'] = $filter;
        }
        
        // Add pagination and custom filters only for paginated APIs
        if ($hasPagination) {
            $params = array_merge($params, $customFilters, [
                'per_page' => $perPage,
                'page' => $page,
            ]);
        } else {
            // For non-paginated APIs, only add custom filters
            $params = array_merge($params, $customFilters);
        }
        
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
            $itemArray = $this->decodeJsonFields($itemArray, $jsonFields);
            $itemArray = $this->resolveRelatedData($itemArray);
            return $itemArray;
        })->toArray();
    }

    /**
     * Decode JSON fields in an array
     */
    protected function decodeJsonFields(array $itemArray, array $jsonFields = []): array
    {
        foreach ($jsonFields as $field) {
            if (isset($itemArray[$field])) {
                $value = $itemArray[$field];
                
                // If it's already an array, keep it as is
                if (is_array($value)) {
                    continue;
                }
                
                // If it's a string, try to decode it
                if (is_string($value)) {
                    $decoded = json_decode($value, true);
                    $itemArray[$field] = $decoded !== null ? $decoded : $value;
                }
                
                // If it's null or other types, keep as is
            }
        }
        
        return $itemArray;
    }

    /**
     * Resolve related data for an item
     */
    protected function resolveRelatedData(array $itemArray): array
    {
        $config = $this->getApiConfig();
        $relatedData = $config['related_data'] ?? [];

        foreach ($relatedData as $field => $apiControllerClass) {
            if (isset($itemArray[$field]) && is_array($itemArray[$field])) {
                $itemArray[$field] = $this->resolveRelatedItem($itemArray[$field], $apiControllerClass);
            }
        }

        // Handle nested data that doesn't have its own API controller
        $itemArray = $this->resolveNestedData($itemArray);

        return $itemArray;
    }

    /**
     * Resolve nested data that doesn't have its own API controller
     */
    protected function resolveNestedData(array $itemArray): array
    {
        // Handle address data within venues
        if (isset($itemArray['address']) && is_array($itemArray['address'])) {
            $itemArray['address'] = $this->resolveAddressData($itemArray['address']);
        }

        return $itemArray;
    }

    /**
     * Resolve address data and save it to the database
     */
    protected function resolveAddressData(array $addressData): array
    {
        try {
            // Check if we have an address ID to resolve
            if (isset($addressData['id'])) {
                $address = \App\Models\Address::where('api_id', $addressData['id'])->first();
                
                if ($address) {
                    // Check if the address data is stale
                    if ($this->isRelatedDataStale($address->toArray())) {
                        // Update the address with fresh data
                        $address->update([
                            'full_address' => $addressData['full_address'] ?? $address->full_address,
                            'street' => $addressData['street'] ?? $address->street,
                            'city' => $addressData['city'] ?? $address->city,
                            'state' => $addressData['state'] ?? $address->state,
                            'zip_code' => $addressData['zip_code'] ?? $address->zip_code,
                            'country' => $addressData['country'] ?? $address->country,
                            'comment' => $addressData['comment'] ?? $address->comment,
                            'lat' => $addressData['lat'] ?? $address->lat,
                            'lng' => $addressData['lng'] ?? $address->lng,
                            'address' => $addressData['address'] ?? $address->address,
                            'fetched_at' => now(),
                        ]);
                    }
                    
                    return $address->toArray();
                } else {
                    // Create new address record
                    $address = \App\Models\Address::create([
                        'api_id' => $addressData['id'],
                        'full_address' => $addressData['full_address'] ?? '',
                        'street' => $addressData['street'] ?? null,
                        'city' => $addressData['city'] ?? null,
                        'state' => $addressData['state'] ?? null,
                        'zip_code' => $addressData['zip_code'] ?? null,
                        'country' => $addressData['country'] ?? null,
                        'comment' => $addressData['comment'] ?? null,
                        'lat' => $addressData['lat'] ?? null,
                        'lng' => $addressData['lng'] ?? null,
                        'address' => $addressData['address'] ?? null,
                        'fetched_at' => now(),
                    ]);
                    
                    return $address->toArray();
                }
            }
            
            // If no ID, return the original data
            return $addressData;
        } catch (\Exception $e) {
            Log::error("Failed to resolve address data: " . $e->getMessage());
            return $addressData;
        }
    }

    /**
     * Resolve a single related item
     */
    protected function resolveRelatedItem(array $relatedData, string $apiControllerClass): array
    {
        try {
            $apiController = new $apiControllerClass();
            
            // For venue data, check different possible ID fields
            if ($apiControllerClass === \App\Http\Controllers\API\VenuesApi::class) {
                $venueId = $relatedData['id'] ?? $relatedData['venue_id'] ?? null;
                if ($venueId) {
                    $venueId = $this->resolveVenueApiId($venueId);
                    if ($venueId) {
                        $resolvedData = $apiController->getItemById($venueId);
                        if (!empty($resolvedData)) {
                            // If this is venue data, we need to handle the address relationship
                            $resolvedData = $this->linkVenueAddress($resolvedData);
                            return $resolvedData;
                        }
                    }
                }
            } else {
                // For other APIs, check if we have an ID to resolve
                if (isset($relatedData['id'])) {
                    $resolvedData = $apiController->getItemById($relatedData['id']);
                    if (!empty($resolvedData)) {
                        return $resolvedData;
                    }
                }
            }
            
            // If no ID or resolution failed, return the original data
            return $relatedData;
        } catch (\Exception $e) {
            Log::error("Failed to resolve related data with {$apiControllerClass}: " . $e->getMessage());
            return $relatedData;
        }
    }

    /**
     * Resolve venue API ID from internal ID or API ID
     */
    protected function resolveVenueApiId($id): ?string
    {
        // First, try to find by API ID
        $venue = \App\Models\Venue::where('api_id', $id)->first();
        if ($venue) {
            return $venue->api_id;
        }
        
        // If not found by API ID, try to find by internal ID
        $venue = \App\Models\Venue::where('id', $id)->first();
        if ($venue) {
            return $venue->api_id;
        }
        
        // If still not found, assume it's already an API ID
        return $id;
    }

    /**
     * Link venue address to the venue model
     */
    protected function linkVenueAddress(array $venueData): array
    {
        if (isset($venueData['address']) && is_array($venueData['address'])) {
            try {
                // Find or create the venue
                $venue = \App\Models\Venue::where('api_id', $venueData['id'])->first();
                
                if ($venue) {
                    // Find or create the address
                    $address = \App\Models\Address::where('api_id', $venueData['address']['id'])->first();
                    
                    if (!$address) {
                        // Create new address
                        $address = \App\Models\Address::create([
                            'api_id' => $venueData['address']['id'],
                            'addressable_type' => \App\Models\Venue::class,
                            'addressable_id' => $venue->id,
                            'full_address' => $venueData['address']['full_address'] ?? '',
                            'street' => $venueData['address']['street'] ?? null,
                            'city' => $venueData['address']['city'] ?? null,
                            'state' => $venueData['address']['state'] ?? null,
                            'zip_code' => $venueData['address']['zip_code'] ?? null,
                            'country' => $venueData['address']['country'] ?? null,
                            'comment' => $venueData['address']['comment'] ?? null,
                            'lat' => $venueData['address']['lat'] ?? null,
                            'lng' => $venueData['address']['lng'] ?? null,
                            'address' => $venueData['address']['address'] ?? null,
                            'fetched_at' => now(),
                        ]);
                    } else {
                        // Update existing address
                        $address->update([
                            'addressable_type' => \App\Models\Venue::class,
                            'addressable_id' => $venue->id,
                            'full_address' => $venueData['address']['full_address'] ?? $address->full_address,
                            'street' => $venueData['address']['street'] ?? $address->street,
                            'city' => $venueData['address']['city'] ?? $address->city,
                            'state' => $venueData['address']['state'] ?? $address->state,
                            'zip_code' => $venueData['address']['zip_code'] ?? $address->zip_code,
                            'country' => $venueData['address']['country'] ?? $address->country,
                            'comment' => $venueData['address']['comment'] ?? $address->comment,
                            'lat' => $venueData['address']['lat'] ?? $address->lat,
                            'lng' => $venueData['address']['lng'] ?? $address->lng,
                            'address' => $venueData['address']['address'] ?? $address->address,
                            'fetched_at' => now(),
                        ]);
                    }
                    
                    // Update the venue data with the linked address
                    $venueData['address'] = $address->toArray();
                }
            } catch (\Exception $e) {
                Log::error("Failed to link venue address: " . $e->getMessage());
            }
        }
        
        return $venueData;
    }

    /**
     * Check if related data is stale and needs resolution
     */
    protected function isRelatedDataStale(array $relatedData): bool
    {
        // Check if data has a timestamp and is older than 5 minutes
        if (isset($relatedData['fetched_at'])) {
            $fetchedAt = \Carbon\Carbon::parse($relatedData['fetched_at']);
            return $fetchedAt->diffInMinutes(now()) > 5;
        }
        
        // If no timestamp, consider it stale
        return true;
    }
} 