<?php

namespace App\Http\Controllers\API;

use App\Models\Venue;
use App\Http\Dto\VenueDto;
use App\Traits\ApiControllerTrait;
use Illuminate\Routing\Controller;

class VenuesApi extends Controller
{
    use ApiControllerTrait;

    protected function getApiConfig(): array
    {
        return [
            'model' => Venue::class,
            'dto' => VenueDto::class,
            'base_endpoint' => '/v1/team/{teamId}/venues',
            'cache_prefix' => 'venues',
            'default_filters' => [],
            'json_fields' => ['venue_type', 'venue_color', 'venue_comment', 'address'],
            'scope_methods' => ['active'],
            'use_team_id' => true,
            'has_pagination' => false, // Venues API doesn't use pagination
        ];
    }

    // Magic methods will handle:
    // - getAllData() -> getPaginatedData('all')
    // - getActiveData() -> getPaginatedData('active')
    // - getVenueById($id) -> getItemById($id)
    // - getVenuesByType($type) -> getItemsByFilter('type', $type)
} 