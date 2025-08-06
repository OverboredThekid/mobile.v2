<?php

namespace App\Http\Controllers\API;

use App\Models\Shift;
use App\Models\CalendarData;
use App\Http\Dto\ShiftDto;
use App\Traits\ApiControllerTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CalendarApi extends Controller
{
    use ApiControllerTrait;

    protected function getApiConfig(): array
    {
        return [
            'model' => Shift::class,
            'dto' => ShiftDto::class,
            'base_endpoint' => '/v1/worker/calendar',
            'meta_endpoint' => '/v1/worker/calendar/meta',
            'cache_prefix' => 'calendar',
            'default_filters' => [],
            'json_fields' => ['userShifts', 'availability', 'timeOff', 'venue'],
            'scope_methods' => ['byDate', 'byDateRange'],
            'use_team_id' => false,
            'has_pagination' => false,
        ];
    }

    /**
     * Get calendar data for a specific date range
     */
    public function getCalendarData(string $from = null, string $to = null, string $userId = null): array
    {
        try {
            $config = $this->getApiConfig();
            
            // Default to current month if no dates provided
            if (!$from) {
                $from = Carbon::now()->startOfMonth()->format('Y-m-d');
            }
            if (!$to) {
                $to = Carbon::now()->endOfMonth()->format('Y-m-d');
            }

            // Get user ID from auth service if not provided
            if (!$userId) {
                $authService = new \App\Services\AuthApiService();
                $user = $authService->getStoredUser();
                $userId = $user['id'] ?? null;
            }

            if (!$userId) {
                Log::error('CalendarApi::getCalendarData no user ID available');
                return [];
            }

            // Get meta data first to check if we need fresh data
            $metaData = $this->getCalendarMeta();
            
            // Check if cached data is stale
            $isStale = CalendarData::isDataStale($userId, $metaData);
            
            if (!$isStale) {
                // Try to get data from database
                $calendarData = CalendarData::getCalendarData($userId, $from, $to);
                
                if (!empty($calendarData)) {
                    Log::debug('CalendarApi using cached data for user: ' . $userId);
                    return $calendarData;
                }
            }

            // Fetch fresh data from API
            Log::debug('CalendarApi fetching fresh data for user: ' . $userId);
            
            // Build API endpoint with date parameters
            $endpoint = $config['base_endpoint'];
            $params = [
                'from' => $from,
                'to' => $to,
            ];

            // Make API call
            $apiService = new \App\Services\ApiService();
            $response = $apiService->get($endpoint . '?' . http_build_query($params));

            // Log the response for debugging
            Log::debug('CalendarApi response:', [
                'endpoint' => $endpoint,
                'params' => $params,
                'response' => $response
            ]);

            // Handle different response structures
            if (is_array($response)) {
                // If response is already the calendar data
                if (isset($response['2025-07-31']) || isset($response['2025-08-01'])) {
                    $calendarData = $response;
                } else {
                    // If response has a data field
                    $calendarData = $response['data'] ?? $response;
                }
            } else {
                Log::error('CalendarApi::getCalendarData invalid response type: ' . gettype($response));
                return [];
            }

            // Process the calendar data structure
            $processedData = $this->processCalendarData($calendarData);

            // Store in database
            CalendarData::storeCalendarData($userId, $processedData, $metaData);

            return $processedData;

        } catch (\Exception $e) {
            Log::error('CalendarApi::getCalendarData exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get calendar meta data
     */
    public function getCalendarMeta(): array
    {
        try {
            $config = $this->getApiConfig();
            $cacheKey = "{$config['cache_prefix']}_meta";
            
            // Check cache first
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }

            // Make API call to meta endpoint
            $apiService = new \App\Services\ApiService();
            $response = $apiService->get($config['meta_endpoint']);

            // Log the response for debugging
            Log::debug('CalendarApi meta response:', [
                'endpoint' => $config['meta_endpoint'],
                'response' => $response
            ]);

            // Handle different response structures
            if (is_array($response)) {
                $metaData = $response['data'] ?? $response;
            } else {
                Log::error('CalendarApi::getCalendarMeta invalid response type: ' . gettype($response));
                return [];
            }

            // Cache the result
            Cache::put($cacheKey, $metaData, now()->addMinutes(15));

            return $metaData;

        } catch (\Exception $e) {
            Log::error('CalendarApi::getCalendarMeta exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Process calendar data to handle the special structure
     */
    protected function processCalendarData(array $calendarData): array
    {
        $processedData = [];

        foreach ($calendarData as $dateKey => $dateData) {
            $processedData[$dateKey] = [
                'userShifts' => $this->processUserShifts($dateData['userShifts'] ?? []),
                'availability' => $this->processAvailability($dateData['availability'] ?? []),
                'timeOff' => $this->processTimeOff($dateData['timeOff'] ?? []),
            ];
        }

        return $processedData;
    }

    /**
     * Process user shifts to handle both confirmed shifts and shift requests
     */
    protected function processUserShifts(array $userShifts): array
    {
        $processedShifts = [];

        foreach ($userShifts as $shift) {
            // Check if this is a shift request (pending status)
            $hasPendingRequest = isset($shift['shiftRequest']) && 
                               $shift['shiftRequest']['status'] === 'pending';

            // Add a flag to distinguish between confirmed shifts and shift requests
            $shift['is_shift_request'] = $hasPendingRequest;
            $shift['shift_type'] = $hasPendingRequest ? 'request' : 'confirmed';

            // Process venue data if present
            if (isset($shift['venue']) && is_array($shift['venue'])) {
                $shift['venue'] = $this->processVenueData($shift['venue']);
            }

            // Process workers data if present
            if (isset($shift['workers']) && is_array($shift['workers'])) {
                $shift['workers'] = $this->processWorkersData($shift['workers']);
            }

            // Process time punches if present
            if (isset($shift['timePunches']) && is_array($shift['timePunches'])) {
                $shift['timePunches'] = $this->processTimePunches($shift['timePunches']);
            }

            $processedShifts[] = $shift;
        }

        return $processedShifts;
    }

    /**
     * Process availability data
     */
    protected function processAvailability(array $availability): array
    {
        $processedAvailability = [];

        foreach ($availability as $item) {
            // Process any nested data structures
            if (isset($item['venue']) && is_array($item['venue'])) {
                $item['venue'] = $this->processVenueData($item['venue']);
            }

            $processedAvailability[] = $item;
        }

        return $processedAvailability;
    }

    /**
     * Process time off data
     */
    protected function processTimeOff(array $timeOff): array
    {
        $processedTimeOff = [];

        foreach ($timeOff as $item) {
            // Process any nested data structures
            if (isset($item['venue']) && is_array($item['venue'])) {
                $item['venue'] = $this->processVenueData($item['venue']);
            }

            $processedTimeOff[] = $item;
        }

        return $processedTimeOff;
    }

    /**
     * Process venue data
     */
    protected function processVenueData(array $venue): array
    {
        // Ensure venue has all required fields
        $venue['id'] = $venue['id'] ?? $venue['venue_id'] ?? null;
        $venue['name'] = $venue['venue_name'] ?? $venue['name'] ?? 'Unknown Venue';
        $venue['address'] = $venue['address'] ?? '';
        $venue['venue_type'] = $venue['venue_type'] ?? [];
        $venue['venue_color'] = $venue['venue_color'] ?? 'gray';

        return $venue;
    }

    /**
     * Process workers data
     */
    protected function processWorkersData(array $workers): array
    {
        $processedWorkers = [];

        foreach ($workers as $worker) {
            // Ensure worker has all required fields
            $worker['user_id'] = $worker['user_id'] ?? null;
            $worker['name'] = $worker['name'] ?? 'Unknown Worker';
            $worker['avatar_url'] = $worker['avatar_url'] ?? null;
            $worker['phone_number'] = $worker['phone_number'] ?? null;
            $worker['email'] = $worker['email'] ?? null;
            $worker['user_shift_status'] = $worker['user_shift_status'] ?? null;
            $worker['shift_request_status'] = $worker['shift_request_status'] ?? null;

            $processedWorkers[] = $worker;
        }

        return $processedWorkers;
    }

    /**
     * Process time punches data
     */
    protected function processTimePunches(array $timePunches): array
    {
        $processedPunches = [];

        foreach ($timePunches as $punch) {
            // Ensure punch has all required fields
            $punch['id'] = $punch['id'] ?? null;
            $punch['type'] = $punch['type'] ?? 'unknown';
            $punch['punch_time'] = $punch['punch_time'] ?? null;
            $punch['order_column'] = $punch['order_column'] ?? 0;

            $processedPunches[] = $punch;
        }

        return $processedPunches;
    }

    /**
     * Get events for a specific date
     */
    public function getEventsForDate(string $date): array
    {
        $calendarData = $this->getCalendarData($date, $date);
        return $calendarData[$date] ?? ['userShifts' => [], 'availability' => [], 'timeOff' => []];
    }

    /**
     * Get events for a date range
     */
    public function getEventsForDateRange(string $from, string $to): array
    {
        return $this->getCalendarData($from, $to);
    }
} 