<?php

namespace App\Http\Dto;

class ShiftDto
{
    public string $id;
    public string $shift_id;
    public string $schedule_id;
    public string $venue_id;
    public string $venue_name;
    public string $title;
    public string $schedule_title;
    public ?string $description;
    public string $start_time;
    public string $end_time;
    public ?int $call_time;
    public string $status;
    public bool $can_punch;
    public bool $can_bailout;
    public bool $is_timeTracker;
    public bool $is_reviewer;
    public ?string $worker_notes;
    public ?string $admin_notes;
    public ?string $schedule_worker_notes;
    public ?string $schedule_admin_notes;
    public ?string $requested_by;
    public ?string $requested_at;
    public array $workers;
    public array $venue;
    public ?array $shiftRequest;
    public array $documents;
    public array $timePunches;
    public string $created_at;
    public string $updated_at;

    public function __construct(
        string $id,
        string $shift_id,
        string $schedule_id,
        string $venue_id,
        string $venue_name,
        string $title,
        string $schedule_title,
        ?string $description,
        string $start_time,
        string $end_time,
        ?int $call_time,
        string $status,
        bool $can_punch,
        bool $can_bailout,
        bool $is_timeTracker,
        bool $is_reviewer,
        ?string $worker_notes,
        ?string $admin_notes,
        ?string $schedule_worker_notes,
        ?string $schedule_admin_notes,
        ?string $requested_by,
        ?string $requested_at,
        array $workers,
        array $venue,
        ?array $shiftRequest,
        array $documents,
        array $timePunches,
        string $created_at,
        string $updated_at
    ) {
        $this->id = $id;
        $this->shift_id = $shift_id;
        $this->schedule_id = $schedule_id;
        $this->venue_id = $venue_id;
        $this->venue_name = $venue_name;
        $this->title = $title;
        $this->schedule_title = $schedule_title;
        $this->description = $description;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->call_time = $call_time;
        $this->status = $status;
        $this->can_punch = $can_punch;
        $this->can_bailout = $can_bailout;
        $this->is_timeTracker = $is_timeTracker;
        $this->is_reviewer = $is_reviewer;
        $this->worker_notes = $worker_notes;
        $this->admin_notes = $admin_notes;
        $this->schedule_worker_notes = $schedule_worker_notes;
        $this->schedule_admin_notes = $schedule_admin_notes;
        $this->requested_by = $requested_by;
        $this->requested_at = $requested_at;
        $this->workers = $workers;
        $this->venue = $venue;
        $this->shiftRequest = $shiftRequest;
        $this->documents = $documents;
        $this->timePunches = $timePunches;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    /**
     * Create DTO from API response array
     */
    public static function fromApiResponse(array $data): self
    {
        // Extract shift request data if available
        $shiftRequest = $data['shiftRequest'] ?? null;
        $requested_by = null;
        $requested_at = null;
        $status = 'confirmed';

        if ($shiftRequest) {
            $requested_by = $shiftRequest['requested_by'] ?? null;
            $requested_at = $shiftRequest['created_at'] ?? null;
            $status = $shiftRequest['status'] ?? 'confirmed';
        }

        // Extract worker count from workers array
        $worker_count = 0;
        $current_workers = 0;
        if (isset($data['workers']) && is_array($data['workers'])) {
            foreach ($data['workers'] as $workerGroup) {
                $worker_count += $workerGroup['worker_count'] ?? 0;
                $current_workers += count($workerGroup['workers'] ?? []);
            }
        }

        return new self(
            $data['id'] ?? '',
            $data['shift_id'] ?? '',
            $data['schedule_id'] ?? '',
            $data['venue_id'] ?? '',
            $data['venue_name'] ?? '',
            $data['title'] ?? '',
            $data['schedule_title'] ?? '',
            $data['description'] ?? null,
            $data['start_time'] ?? '',
            $data['end_time'] ?? '',
            $data['call_time'] ?? null,
            $status,
            $data['can_punch'] ?? false,
            $data['can_bailout'] ?? false,
            $data['is_timeTracker'] ?? false,
            $data['is_reviewer'] ?? false,
            $data['worker_notes'] ?? null,
            $data['admin_notes'] ?? null,
            $data['schedule_worker_notes'] ?? null,
            $data['schedule_admin_notes'] ?? null,
            $requested_by,
            $requested_at,
            $data['workers'] ?? [],
            $data['venue'] ?? [],
            $shiftRequest,
            $data['documents'] ?? [],
            $data['timePunches'] ?? [],
            $data['created_at'] ?? '',
            $data['updated_at'] ?? ''
        );
    }

    /**
     * Convert to array for database storage
     */
    public function toArray(): array
    {
        // Calculate worker count from workers array
        $worker_count = 0;
        $current_workers = 0;
        if (!empty($this->workers)) {
            foreach ($this->workers as $workerGroup) {
                $worker_count += $workerGroup['worker_count'] ?? 0;
                $current_workers += count($workerGroup['workers'] ?? []);
            }
        }

        return [
            'api_id' => $this->id,
            'shift_id' => $this->shift_id,
            'schedule_id' => $this->schedule_id,
            'venue_id' => $this->venue_id,
            'venue_name' => $this->venue_name,
            'title' => $this->title,
            'schedule_title' => $this->schedule_title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'call_time' => $this->call_time,
            'status' => $this->status,
            'worker_count' => $worker_count,
            'current_workers' => $current_workers,
            'can_punch' => $this->can_punch,
            'can_bailout' => $this->can_bailout,
            'is_timeTracker' => $this->is_timeTracker,
            'is_reviewer' => $this->is_reviewer,
            'worker_notes' => $this->worker_notes,
            'admin_notes' => $this->admin_notes,
            'schedule_worker_notes' => $this->schedule_worker_notes,
            'schedule_admin_notes' => $this->schedule_admin_notes,
            'requested_by' => $this->requested_by,
            'requested_at' => $this->requested_at,
            'workers' => json_encode($this->workers),
            'venue' => json_encode($this->venue),
            'shift_request' => json_encode($this->shiftRequest),
            'documents' => json_encode($this->documents),
            'time_punches' => json_encode($this->timePunches),
        ];
    }
} 