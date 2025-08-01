<?php

namespace App\Livewire\Dashboard\Ui;

use App\Http\Controllers\API\ShiftRequestApi;
use App\Http\Controllers\API\AvailableShiftsApi;
use App\Traits\HasVenueModal;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class ShiftActions extends Component
{
    public $shiftRequestsCount = 0;
    public $availableShiftsCount = 0;
    public $loading = true;

    use HasVenueModal;

    public function mount()
    {
        $this->loadCounts();
    }

    public function loadCounts()
    {
        $this->loading = true;

        try {
            // Get shift requests count
            $shiftRequestApi = new ShiftRequestApi();
            $shiftRequestsData = $shiftRequestApi->getCountData();
            $this->shiftRequestsCount = $shiftRequestsData['count'] ?? 0;

            // Get available shifts count
            $availableShiftsApi = new AvailableShiftsApi();
            $availableShiftsData = $availableShiftsApi->getCountData();
            $this->availableShiftsCount = $availableShiftsData['count'] ?? 0;

        } catch (\Exception $e) {
            // Log error but don't break the component
            Log::error('Failed to load shift counts: ' . $e->getMessage());
            $this->shiftRequestsCount = 0;
            $this->availableShiftsCount = 0;
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.dashboard.ui.shift-actions');
    }
}

