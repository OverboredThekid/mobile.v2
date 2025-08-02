<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Dto\UserDto;
use App\Traits\ApiControllerTrait;
use Illuminate\Routing\Controller;

class UsersApi extends Controller
{
    use ApiControllerTrait;

    protected function getApiConfig(): array
    {
        return [
            'model' => User::class,
            'dto' => UserDto::class,
            'base_endpoint' => '/v1/team/{teamId}/users',
            'cache_prefix' => 'users',
            'default_filters' => [],
            'json_fields' => ['roles'],
            'scope_methods' => ['active'],
            'use_team_id' => true,
        ];
    }

    // Magic methods will handle:
    // - getAllData() -> getPaginatedData('all')
    // - getActiveData() -> getPaginatedData('active')
    // - getUserById($id) -> getItemById($id)
    // - getUsersByRole($role) -> getItemsByFilter('role', $role)
} 