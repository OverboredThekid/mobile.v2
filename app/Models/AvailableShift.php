<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AvailableShift extends Model
{
    protected $fillable = [
        'api_id',
        'shiftRequest_id',
        'shift_id',
        'schedule_id',
        'schedule_worker_notes',
        'schedule_admin_notes',
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
     * Scope for upcoming available shifts
     */
    public function scopeUpcoming(Builder $query): void
    {
        $query->where('start_time', '>=', now());
    }

    /**
     * Scope for past available shifts
     */
    public function scopePast(Builder $query): void
    {
        $query->where('start_time', '<', now());
    }

    /**
     * Scope for all available shifts (no filter)
     */
    public function scopeAll(Builder $query): void
    {
        // No additional filtering needed
    }

    /**
     * Scope for available shifts by venue
     */
    public function scopeByVenue(Builder $query, string $venueId): void
    {
        $query->where('venue_id', $venueId);
    }

    /**
     * Scope for available shifts by schedule
     */
    public function scopeBySchedule(Builder $query, string $scheduleId): void
    {
        $query->where('schedule_id', $scheduleId);
    }
} 