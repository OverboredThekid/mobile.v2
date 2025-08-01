<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShiftRequest extends Model
{
    protected $fillable = [
        'api_id',
        'shift_id',
        'schedule_id',
        'schedule_worker_notes',
        'schedule_admin_notes',
        'requested_by',
        'status',
        'venue_id',
        'venue_name',
        'title',
        'schedule_title',
        'call_time',
        'start_time',
        'end_time',
        'worker_notes',
        'admin_notes',
        'workers',
        'venue',
        'etag',
        'fetched_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'call_time' => 'integer',
        'workers' => 'array',
        'venue' => 'array',
        'fetched_at' => 'datetime',
    ];

    /**
     * Scope for pending shift requests
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }

    /**
     * Scope for confirmed shift requests
     */
    public function scopeConfirmed(Builder $query): void
    {
        $query->where('status', 'confirmed');
    }

    /**
     * Scope for declined shift requests
     */
    public function scopeDeclined(Builder $query): void
    {
        $query->where('status', 'declined');
    }

    /**
     * Scope for shift requests by user
     */
    public function scopeByUser(Builder $query, string $userId): void
    {
        $query->where('requested_by', $userId);
    }

    /**
     * Scope for upcoming shift requests
     */
    public function scopeUpcoming(Builder $query): void
    {
        $query->where('start_time', '>=', now());
    }

    /**
     * Scope for past shift requests
     */
    public function scopePast(Builder $query): void
    {
        $query->where('start_time', '<', now());
    }

    /**
     * Scope for all shift requests (no filter)
     */
    public function scopeAll(Builder $query): void
    {
        // No additional filtering needed
    }

    /**
     * Check if the request is stale based on etag
     */
    public function isStale($currentEtag): bool
    {
        return $this->etag !== $currentEtag;
    }

    /**
     * Update the model with fresh data from API
     */
    public function updateFromApi(array $data, string $etag): void
    {
        $this->update(array_merge($data, [
            'etag' => $etag,
            'fetched_at' => now(),
        ]));
    }
} 