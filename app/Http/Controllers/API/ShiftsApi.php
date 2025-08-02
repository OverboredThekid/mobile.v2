<?php

namespace App\Http\Controllers\API;

use App\Models\Shift;
use App\Http\Dto\ShiftDto;
use App\Traits\ApiControllerTrait;
use Illuminate\Routing\Controller;

class ShiftsApi extends Controller
{
    use ApiControllerTrait;

    protected function getApiConfig(): array
    {
        return [
            'model' => Shift::class,
            'dto' => ShiftDto::class,
            'base_endpoint' => '/worker/{teamId}/schedule/my-shifts',
            'cache_prefix' => 'shifts',
            'default_filters' => ['confirmed' => true],
            'json_fields' => ['workers', 'venue', 'shift_request', 'documents', 'time_punches'],
            'scope_methods' => ['confirmed', 'upcoming', 'past', 'bySchedule', 'byVenue'],
            'use_team_id' => true,
            'related_data' => [
                'venue' => \App\Http\Controllers\API\VenuesApi::class,
                'workers' => \App\Http\Controllers\API\UsersApi::class,
            ],
        ];
    }

    // Magic methods will handle:
    // - getUpcomingData() -> getPaginatedData('upcoming')
    // - getPastData() -> getPaginatedData('past')
    // - getAllData() -> getPaginatedData('all')
    // - getShiftById($id) -> getItemById($id)
    // - getShiftsBySchedule($scheduleId) -> getItemsByFilter('schedule', $scheduleId)
    // - getShiftsByVenue($venueId) -> getItemsByFilter('venue', $venueId)
} 