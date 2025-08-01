<?php

namespace App\Livewire\User\Component;

use App\Http\Controllers\API\ShiftsApi;
use App\Http\Dto\VenueDto;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;

class ShiftDetails extends Component
{
    public $shiftId;

    #[Url]
    public $shift;
    public $shiftData = null;
    public $actions = [];
    public $loading = true;
    public $lastUpdated = null;
    public $activeTab = 'details';

    protected ShiftsApi $shiftsApi;

    public function boot(ShiftsApi $shiftsApi)
    {
        $this->shiftsApi = $shiftsApi;
    }

    public function mount($shiftData = null)
    {
        Log::info('ShiftDetails: mount() called', [
            'shiftData' => $shiftData ? 'present' : 'null',
            'hasApiId' => isset($shiftData['api_id']),
            'apiId' => $shiftData['api_id'] ?? 'none'
        ]);
        
        $this->shiftData = $shiftData;
        
        // Extract shift ID from data
        $this->shiftId = $shiftData['api_id'] ?? null;
        
        // Use provided data if available and fresh, otherwise fetch from API
        if ($this->shiftData && $this->isDataFresh($this->shiftData)) {
            Log::info('ShiftDetails: Using fresh data, no API call needed');
            $this->shift = $this->shiftData;
            $this->loading = false;
            $this->lastUpdated = now();
        } else {
            Log::info('ShiftDetails: Data is stale or missing, making API call');
            $this->loadShiftDetails();
        }
    }

    protected function isDataFresh($data)
    {
        // Consider data fresh if it has essential fields
        if (!is_array($data) || empty($data)) {
            return false;
        }

        // Check if data has required fields
        $requiredFields = ['api_id', 'title', 'start_time', 'end_time'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return false;
            }
        }

        // If data has meta_updated_at, check if it's fresh (less than 5 minutes old)
        if (isset($data['meta_updated_at'])) {
            $dataAge = now()->diffInMinutes(\Carbon\Carbon::parse($data['meta_updated_at']));
            return $dataAge < 5; // Fresh if less than 5 minutes old
        }

        // If data has updated_at, check if it's fresh (less than 5 minutes old)
        if (isset($data['updated_at'])) {
            $dataAge = now()->diffInMinutes(\Carbon\Carbon::parse($data['updated_at']));
            return $dataAge < 5; // Fresh if less than 5 minutes old
        }

        // If no timestamp is available, consider it fresh if it has all required fields
        // This prevents unnecessary API calls for data that might be fresh but doesn't have timestamps
        return true;
    }

    public function loadShiftDetails()
    {
        Log::info('ShiftDetails: loadShiftDetails() called', [
            'shiftId' => $this->shiftId
        ]);
        
        $this->loading = true;

        try {
            if (!$this->shiftId) {
                throw new \Exception('No shift ID provided');
            }

            Log::info('ShiftDetails: Making API call to getShiftById', [
                'shiftId' => $this->shiftId
            ]);
            
            $shiftData = $this->shiftsApi->getShiftById($this->shiftId);
            
            Log::info('ShiftDetails: API call successful', [
                'shiftId' => $this->shiftId,
                'dataReceived' => !empty($shiftData)
            ]);
            
            // Ensure we're working with arrays and add meta timestamp
            $this->shift = is_array($shiftData) ? array_merge($shiftData, [
                'meta_updated_at' => now()->toISOString()
            ]) : [];
            
            $this->lastUpdated = now();
        } catch (\Exception $e) {
            Log::error('ShiftDetails: API call failed', [
                'shiftId' => $this->shiftId,
                'error' => $e->getMessage()
            ]);
            
            // If API fails and we have initial data, use it
            if ($this->shiftData) {
                $this->shift = $this->shiftData;
            } else {
                $this->shift = null;
            }
        } finally {
            $this->loading = false;
        }
    }

    public function refreshData()
    {
        $this->loadShiftDetails();
    }

    #[On('refresh-shift-details')]
    public function handleRefresh()
    {
        $this->refreshData();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function executeAction($actionKey)
    {
        $action = collect($this->actions)->firstWhere('key', $actionKey);
        
        if (!$action) {
            return;
        }

        try {
            if (isset($action['method'])) {
                $this->dispatch($action['method'], shiftId: $this->shiftId);
            }

            if (isset($action['callback'])) {
                $this->dispatch($action['callback'], shiftId: $this->shiftId);
            }

            // Refresh data after action
            $this->refreshData();
        } catch (\Exception $e) {
            // Handle error
        }
    }

    public function getVenueDto(): ?VenueDto
    {
        if (!is_array($this->shift) || !isset($this->shift['venue'])) {
            return null;
        }
        
        return VenueDto::fromArray($this->shift['venue']);
    }

    public function getStatusColor()
    {
        if (!is_array($this->shift) || !isset($this->shift['status'])) {
            return 'bg-gray-500';
        }
        
        return match($this->shift['status']) {
            'confirmed' => 'bg-green-500',
            'pending' => 'bg-yellow-500',
            'declined' => 'bg-red-500',
            'cancelled' => 'bg-gray-500',
            default => 'bg-gray-500'
        };
    }

    public function getStatusText()
    {
        if (!is_array($this->shift) || !isset($this->shift['status'])) {
            return '';
        }
        return ucfirst($this->shift['status']);
    }

    public function getFormattedDate()
    {
        if (!is_array($this->shift) || !isset($this->shift['start_time'])) {
            return '';
        }
        return \Carbon\Carbon::parse($this->shift['start_time'])->format('l, F j');
    }

    public function getFormattedTime()
    {
        if (!is_array($this->shift) || !isset($this->shift['start_time']) || !isset($this->shift['end_time'])) {
            return '';
        }
        $start = \Carbon\Carbon::parse($this->shift['start_time'])->format('g:i A');
        $end = \Carbon\Carbon::parse($this->shift['end_time'])->format('g:i A');
        return "{$start} - {$end}";
    }

    public function getFormattedCallTime()
    {
        if (!is_array($this->shift) || !isset($this->shift['call_time']) || !$this->shift['call_time']) {
            return null;
        }
        
        if (!isset($this->shift['start_time'])) {
            return null;
        }
        
        $startTime = \Carbon\Carbon::parse($this->shift['start_time'])->subMinutes($this->shift['call_time']);
        return $startTime->format('g:i A');
    }

    public function getDuration()
    {
        if (!is_array($this->shift) || !isset($this->shift['start_time']) || !isset($this->shift['end_time'])) {
            return '';
        }
        $start = \Carbon\Carbon::parse($this->shift['start_time']);
        $end = \Carbon\Carbon::parse($this->shift['end_time']);
        $hours = $start->diffInHours($end);
        $minutes = $start->diffInMinutes($end) % 60;
        
        if ($minutes > 0) {
            return "{$hours}h {$minutes}m";
        }
        return "{$hours}h";
    }

    public function getWorkerCount()
    {
        if (!is_array($this->shift) || !isset($this->shift['workers'])) {
            return 0;
        }
        
        $total = 0;
        foreach ($this->shift['workers'] as $workerGroup) {
            $total += $workerGroup['worker_count'] ?? 0;
        }
        return $total;
    }

    public function getCurrentWorkers()
    {
        if (!is_array($this->shift) || !isset($this->shift['workers'])) {
            return 0;
        }
        
        $total = 0;
        foreach ($this->shift['workers'] as $workerGroup) {
            $total += count($workerGroup['workers'] ?? []);
        }
        return $total;
    }

    public function getRequestedBy()
    {
        if (!is_array($this->shift)) {
            return null;
        }
        
        if (isset($this->shift['shift_request']) && is_array($this->shift['shift_request'])) {
            return $this->shift['shift_request']['requested_by'] ?? null;
        }
        return $this->shift['requested_by'] ?? null;
    }

    public function hasTimePunches()
    {
        return is_array($this->shift) && 
               isset($this->shift['timePunches']) && 
               is_array($this->shift['timePunches']) && 
               count($this->shift['timePunches']) > 0;
    }

    public function hasWorkers()
    {
        return is_array($this->shift) && 
               isset($this->shift['workers']) && 
               is_array($this->shift['workers']) && 
               count($this->shift['workers']) > 0;
    }

    public function hasNotes()
    {
        return is_array($this->shift) && 
               (isset($this->shift['notes_admin']) || isset($this->shift['notes_worker']));
    }

    public function hasShiftNotes()
    {
        return is_array($this->shift) && 
               (isset($this->shift['notes_admin']) || isset($this->shift['notes_worker']));
    }

    public function hasDocuments()
    {
        return is_array($this->shift) && 
               isset($this->shift['documents']) && 
               is_array($this->shift['documents']) && 
               count($this->shift['documents']) > 0;
    }

    public function render()
    {
        return view('livewire.user.component.shift-details');
    }
}
