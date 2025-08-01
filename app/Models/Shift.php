<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_id',
        'shift_id',
        'schedule_id',
        'venue_id',
        'venue_name',
        'title',
        'schedule_title',
        'description',
        'start_time',
        'end_time',
        'call_time',
        'status',
        'worker_count',
        'current_workers',
        'can_punch',
        'can_bailout',
        'is_timeTracker',
        'is_reviewer',
        'worker_notes',
        'admin_notes',
        'schedule_worker_notes',
        'schedule_admin_notes',
        'requested_by',
        'requested_at',
        'workers',
        'venue',
        'shift_request',
        'documents',
        'time_punches',
        'etag',
        'fetched_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'fetched_at' => 'datetime',
        'requested_at' => 'datetime',
        'call_time' => 'integer',
        'can_punch' => 'boolean',
        'can_bailout' => 'boolean',
        'is_timeTracker' => 'boolean',
        'is_reviewer' => 'boolean',
        'workers' => 'array',
        'venue' => 'array',
        'shift_request' => 'array',
        'documents' => 'array',
        'time_punches' => 'array',
    ];

    /**
     * Scope to get confirmed shifts
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope to get shifts starting from now
     */
    public function scopeUpcoming($query)
    {
        return $query->where('end_time', '>=', now());
    }

    /**
     * Scope to get shifts that have ended
     */
    public function scopePast($query)
    {
        return $query->where('end_time', '<', now());
    }

    /**
     * Scope to get shifts by schedule
     */
    public function scopeBySchedule($query, $scheduleId)
    {
        return $query->where('schedule_id', $scheduleId);
    }

    /**
     * Scope to get shifts by venue
     */
    public function scopeByVenue($query, $venueId)
    {
        return $query->where('venue_id', $venueId);
    }

    /**
     * Check if the shift is stale based on etag
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

    /**
     * Get the duration of the shift in hours
     */
    public function getDurationAttribute(): float
    {
        return $this->start_time->diffInHours($this->end_time, true);
    }

    /**
     * Check if the shift is active (can be punched in/out)
     */
    public function isActive(): bool
    {
        $now = now();
        return $now->between($this->start_time, $this->end_time);
    }

    /**
     * Check if the shift is upcoming (not started yet)
     */
    public function isUpcoming(): bool
    {
        return now()->lt($this->start_time);
    }

    /**
     * Check if the shift is completed
     */
    public function isCompleted(): bool
    {
        return now()->gt($this->end_time);
    }

    /**
     * Get call time as formatted string
     */
    public function getFormattedCallTimeAttribute(): ?string
    {
        if (!$this->call_time) {
            return null;
        }
        
        $startTime = $this->start_time->copy()->subMinutes($this->call_time);
        return $startTime->format('g:i A');
    }

    /**
     * Get workers array
     */
    public function getWorkersArrayAttribute(): array
    {
        return $this->workers ?? [];
    }

    /**
     * Get venue array
     */
    public function getVenueArrayAttribute(): array
    {
        return $this->venue ?? [];
    }

    /**
     * Get shift request array
     */
    public function getShiftRequestArrayAttribute(): ?array
    {
        return $this->shift_request;
    }
} 