<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

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
            if ($model = $modelClass::find($id)) {
                return $model;
            }
        }

        return null;
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
