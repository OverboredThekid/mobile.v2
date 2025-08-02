<?php

namespace App\Livewire\User\Component\Shifts;

use App\Http\Controllers\API\ShiftsApi;
use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;

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
    
    // Cache for each tab's data
    public $tabCache = [
        'all' => [],
        'upcoming' => [],
        'past' => []
    ];
    
    // Loading states for each tab
    public $tabLoading = [
        'all' => false,
        'upcoming' => false,
        'past' => false
    ];

    protected ShiftsApi $shiftsApi;

    public function boot(ShiftsApi $shiftsApi)
    {
        $this->shiftsApi = $shiftsApi;
    }

    public function mount($activeTab = 'upcoming')
    {
        $this->activeTab = $activeTab;
        $this->loadTabData($activeTab);
    }

    public function loadTabData($tab, $forceRefresh = false)
    {
        // If we have cached data and not forcing refresh, use it immediately
        if (!$forceRefresh && !empty($this->tabCache[$tab])) {
            $this->shifts = $this->tabCache[$tab];
            $this->loading = false;
            return;
        }
        
        // Set loading state for this tab
        $this->tabLoading[$tab] = true;
        $this->loading = true;
        
        // Load data synchronously for immediate response
        $this->loadTabDataSync($tab);
    }

    public function loadTabDataSync($tab)
    {
        try {
            $method = 'get' . ucfirst($tab) . 'Data';
            $shifts = $this->shiftsApi->$method(1, $this->perPage);
            
            // Update the cache and display
            $this->updateTabData($tab, $shifts);
        } catch (\Exception $e) {
            $this->tabLoading[$tab] = false;
            $this->loading = false;
            
            // Log the error
            \Illuminate\Support\Facades\Log::error("Failed to load tab data for {$tab}: {$e->getMessage()}");
        }
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
                
                // Update cache
                $this->tabCache[$this->activeTab] = $this->shifts;
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
        
        // Load tab data (will use cache if available)
        $this->loadTabData($tab);
    }

    public function refreshTabData($tab)
    {
        $this->loadTabData($tab, true);
    }

    public function updateTabData($tab, $data)
    {
        $this->tabCache[$tab] = $data;
        $this->tabLoading[$tab] = false;
        
        // If this is the active tab, update the display
        if ($this->activeTab === $tab) {
            $this->shifts = $data;
            $this->loading = false;
        }
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