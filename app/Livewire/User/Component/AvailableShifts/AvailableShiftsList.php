<?php

namespace App\Livewire\User\Component\AvailableShifts;

use App\Http\Controllers\API\AvailableShiftsApi;
use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class AvailableShiftsList extends Component
{
    public $availableShifts = [];
    public $loading = true;
    public $currentPage = 1;
    public $perPage = 10;
    public $hasMoreShifts = true;
    public $loadingMore = false;

    protected AvailableShiftsApi $availableShiftsApi;

    public function boot(AvailableShiftsApi $availableShiftsApi)
    {
        $this->availableShiftsApi = $availableShiftsApi;
    }

    public function mount()
    {
        $this->loadInitialShifts();
    }

    public function loadInitialShifts()
    {
        $this->loading = true;
        
        try {
            $this->availableShifts = $this->availableShiftsApi->getAllData($this->currentPage, $this->perPage);
            
            // Check if there are more shifts
            $this->hasMoreShifts = count($this->availableShifts) >= $this->perPage;
        } catch (\Exception $e) {
            $this->availableShifts = [];
            $this->hasMoreShifts = false;
        }
        
        $this->loading = false;
    }

    public function loadMoreShifts()
    {
        if (!$this->hasMoreShifts || $this->loadingMore) {
            return;
        }

        $this->loadingMore = true;
        $this->currentPage++;

        try {
            $newShifts = $this->availableShiftsApi->getAllData($this->currentPage, $this->perPage);
            
            if (!empty($newShifts)) {
                $this->availableShifts = array_merge($this->availableShifts, $newShifts);
                $this->hasMoreShifts = count($newShifts) >= $this->perPage;
            } else {
                $this->hasMoreShifts = false;
            }
        } catch (\Exception $e) {
            $this->hasMoreShifts = false;
        }

        $this->loadingMore = false;
    }

    public function getAvailableShiftActions($availableShift)
    {
        return [\App\Enum\shiftActions::REQUEST_SHIFT->value];
    }

    public function getAvailableShiftCardOptions($availableShift)
    {
        return [
            'type' => 'available',
            'showRequestedBy' => false,
            'showStatus' => false,
            'showCallTime' => true,
            'showVenue' => true,
            'showHourlyRate' => false,
            'showWorkerCount' => true,
        ];
    }

    public function requestShift($shiftId)
    {
        // Implement request shift logic
        $this->dispatch('requestShift', shiftId: $shiftId);
    }

    public function render()
    {
        return view('livewire.user.component.available-shifts.available-shifts-list');
    }

    public function placeholder()
    {
        return view('livewire.user.component.available-shifts.available-shifts-list-placeholder');
    }
} 