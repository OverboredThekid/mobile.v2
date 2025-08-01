<?php

namespace App\Http\Dto;

class ShiftRequestDto
{
    public function __construct(
        public string $id,
        public string $shift_id,
        public string $schedule_id,
        public ?string $schedule_worker_notes,
        public ?string $schedule_admin_notes,
        public string $requested_by,
        public string $status,
        public string $venue_id,
        public string $venue_name,
        public string $title,
        public string $schedule_title,
        public int $call_time,
        public string $start_time,
        public string $end_time,
        public ?string $worker_notes,
        public ?string $admin_notes,
        public array $workers,
        public array $venue
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            shift_id: $data['shift_id'] ?? '',
            schedule_id: $data['schedule_id'] ?? '',
            schedule_worker_notes: $data['schedule_worker_notes'] ?? null,
            schedule_admin_notes: $data['schedule_admin_notes'] ?? null,
            requested_by: $data['requested_by'] ?? '',
            status: $data['status'] ?? 'pending',
            venue_id: $data['venue_id'] ?? '',
            venue_name: $data['venue_name'] ?? '',
            title: $data['title'] ?? '',
            schedule_title: $data['schedule_title'] ?? '',
            call_time: $data['call_time'] ?? 0,
            start_time: $data['start_time'] ?? '',
            end_time: $data['end_time'] ?? '',
            worker_notes: $data['worker_notes'] ?? null,
            admin_notes: $data['admin_notes'] ?? null,
            workers: $data['workers'] ?? [],
            venue: $data['venue'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'api_id' => $this->id,
            'shift_id' => $this->shift_id,
            'schedule_id' => $this->schedule_id,
            'schedule_worker_notes' => $this->schedule_worker_notes,
            'schedule_admin_notes' => $this->schedule_admin_notes,
            'requested_by' => $this->requested_by,
            'status' => $this->status,
            'venue_id' => $this->venue_id,
            'venue_name' => $this->venue_name,
            'title' => $this->title,
            'schedule_title' => $this->schedule_title,
            'call_time' => $this->call_time,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'worker_notes' => $this->worker_notes,
            'admin_notes' => $this->admin_notes,
            'workers' => json_encode($this->workers),
            'venue' => json_encode($this->venue),
        ];
    }
}