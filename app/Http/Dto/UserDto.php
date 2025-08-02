<?php

namespace App\Http\Dto;

use Illuminate\Support\Carbon;

class UserDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public ?string $phone = null,
        public ?string $avatar = null,
        public array $roles = [],
        public array $permissions = [],
        public ?string $status = null,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            email: $data['email'] ?? '',
            phone: $data['phone'] ?? null,
            avatar: $data['avatar'] ?? null,
            roles: $data['roles'] ?? [],
            permissions: $data['permissions'] ?? [],
            status: $data['status'] ?? null,
            created_at: isset($data['created_at']) ? Carbon::parse($data['created_at']) : null,
            updated_at: isset($data['updated_at']) ? Carbon::parse($data['updated_at']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'status' => $this->status,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    public function getDisplayName(): string
    {
        return $this->name ?: $this->email;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
} 