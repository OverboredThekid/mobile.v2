<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ModelAutoResolver
{
    protected array $modelClasses = [];

    public function __construct()
    {
        // You can make this dynamic via config or scanning later
        $this->modelClasses = config('model-resolver.models', [
            \App\Models\Shift::class,
            \App\Models\ShiftRequest::class,
            \App\Models\AvailableShift::class,
            \App\Models\Venue::class,
        ]);
    }

    public function resolve(string $id): ?Model
    {
        foreach ($this->modelClasses as $modelClass) {
            /** @var Model $modelClass */

            // First try by primary key (ULID or numeric)
            $model = $modelClass::query()->find($id);
            if ($model) {
                return $model;
            }

            // Then try by api_id column if it exists
            if ($this->modelHasApiId($modelClass)) {
                $model = $modelClass::query()->where('api_id', $id)->first();
                if ($model) {
                    return $model;
                }
            }
        }

        return null;
    }

    protected function modelHasApiId(string $modelClass): bool
    {
        return in_array('api_id', (new $modelClass)->getFillable()) || 
            Schema::hasColumn((new $modelClass)->getTable(), 'api_id');
    }

    public function registerModel(string $class): static
    {
        $this->modelClasses[] = $class;

        return $this;
    }

    public function registerMany(array $classes): static
    {
        $this->modelClasses = array_merge($this->modelClasses, $classes);

        return $this;
    }
}
