<?php

namespace App\Livewire\User\Component\Shifts;

use App\Http\Controllers\API\ShiftsApi;
use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class ShiftsList extends Component
{
    public $activeTab = 'upcoming';
    public $shifts = [];
    public $loading = true;
    public $currentPage = 1;
    public $perPage = 10;
    public $hasMoreShifts = true;
    public $loadingMore = false;

    protected ShiftsApi $shiftsApi;

    public function boot(ShiftsApi $shiftsApi)
    {
        $this->shiftsApi = $shiftsApi;
    }

    public function mount($activeTab = 'upcoming')
    {
        $this->activeTab = $activeTab;
        $this->loadInitialShifts();
    }

    public function loadInitialShifts()
    {
        $this->loading = true;
        
        try {
            $method = 'get' . ucfirst($this->activeTab) . 'Data';
            $this->shifts = $this->shiftsApi->$method($this->currentPage, $this->perPage);
            
            // Check if there are more shifts
            $this->hasMoreShifts = count($this->shifts) >= $this->perPage;
        } catch (\Exception $e) {
            $this->shifts = [];
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
            $method = 'get' . ucfirst($this->activeTab) . 'Data';
            $newShifts = $this->shiftsApi->$method($this->currentPage, $this->perPage);

            if (!empty($newShifts)) {
                $this->shifts = array_merge($this->shifts, $newShifts);
                $this->hasMoreShifts = count($newShifts) >= $this->perPage;
            } else {
                $this->hasMoreShifts = false;
            }
        } catch (\Exception $e) {
            $this->hasMoreShifts = false;
        }

        $this->loadingMore = false;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->currentPage = 1;
        $this->hasMoreShifts = true;
        $this->loadInitialShifts();
    }

    public function render()
    {
        return view('livewire.user.component.shifts.shifts-list');
    }

    public function placeholder()
    {
        return view('livewire.user.component.shifts.shifts-list-placeholder');
    }
} 