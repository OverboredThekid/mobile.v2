<?php

namespace App\Http\Controllers\API;

use App\Models\AvailableShift;
use App\Http\Dto\AvailableShiftDto;
use App\Traits\ApiControllerTrait;
use Illuminate\Routing\Controller;

class AvailableShiftsApi extends Controller
{
    use ApiControllerTrait;

    protected function getApiConfig(): array
    {
        return [
            'model' => AvailableShift::class,
            'dto' => AvailableShiftDto::class,
            'base_endpoint' => '/worker/{teamId}/schedule/available-shifts',
            'count_endpoint' => '/v1/worker/available-shifts/available-count',
            'cache_prefix' => 'available_shifts',
            'default_filters' => [],
            'json_fields' => ['workers', 'venue'],
            'scope_methods' => ['upcoming', 'byVenue', 'bySchedule'],
            'use_team_id' => true,
            'related_data' => [
                'venue' => \App\Http\Controllers\API\VenuesApi::class,
                'workers' => \App\Http\Controllers\API\UsersApi::class,
            ],
        ];
    }

    // Magic methods will handle:
    // - getAllData() -> getPaginatedData('all')
    // - getUpcomingData() -> getPaginatedData('upcoming')
    // - getPastData() -> getPaginatedData('past')
    // - getCountData() -> getCountData()
    // - getItemById($id) -> getItemById($id)
    // - getItemsByVenue($venueId) -> getItemsByFilter('venue', $venueId)
    // - getItemsBySchedule($scheduleId) -> getItemsByFilter('schedule', $scheduleId)
} 