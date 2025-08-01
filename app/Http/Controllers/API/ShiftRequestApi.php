<?php

namespace App\Http\Controllers\API;

use App\Models\ShiftRequest;
use App\Http\Dto\ShiftRequestDto;
use App\Traits\ApiControllerTrait;
use Illuminate\Routing\Controller;

class ShiftRequestApi extends Controller
{
    use ApiControllerTrait;

    protected function getApiConfig(): array
    {
        return [
            'model' => ShiftRequest::class,
            'dto' => ShiftRequestDto::class,
            'base_endpoint' => '/worker/{teamId}/schedule/shift-requests',
            'count_endpoint' => '/v1/worker/shift-requests/pending-count',
            'cache_prefix' => 'shift_requests',
            'default_filters' => ['pending' => true],
            'json_fields' => ['workers', 'venue'],
            'scope_methods' => ['pending'],
            'use_team_id' => true,
        ];
    }

    // Magic methods will handle:
    // - getAllData() -> getPaginatedData('all')
    // - getPendingData() -> getPaginatedData('pending')
    // - getConfirmedData() -> getPaginatedData('confirmed')
    // - getDeclinedData() -> getPaginatedData('declined')
    // - getCountData() -> getCountData()
    // - getItemById($id) -> getItemById($id)
    // - getItemsByUser($userId) -> getItemsByFilter('user', $userId)
}
