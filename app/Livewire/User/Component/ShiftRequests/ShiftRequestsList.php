<?php

namespace App\Livewire\User\Component\ShiftRequests;

use App\Http\Controllers\API\ShiftRequestApi;
use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class ShiftRequestsList extends Component
{
    public $activeTab = 'pending';
    public $shiftRequests = [];
    public $loading = true;
    public $currentPage = 1;
    public $perPage = 10;
    public $hasMoreRequests = true;
    public $loadingMore = false;

    protected ShiftRequestApi $shiftRequestApi;

    public function boot(ShiftRequestApi $shiftRequestApi)
    {
        $this->shiftRequestApi = $shiftRequestApi;
    }

    public function mount($activeTab = 'pending')
    {
        $this->activeTab = $activeTab;
        $this->loadInitialRequests();
    }

    public function loadInitialRequests()
    {
        $this->loading = true;
        
        try {
            $method = 'get' . ucfirst($this->activeTab) . 'Data';
            $this->shiftRequests = $this->shiftRequestApi->$method($this->currentPage, $this->perPage);
            
            // Check if there are more requests
            $this->hasMoreRequests = count($this->shiftRequests) >= $this->perPage;
        } catch (\Exception $e) {
            $this->shiftRequests = [];
            $this->hasMoreRequests = false;
        }
        
        $this->loading = false;
    }

    public function loadMoreRequests()
    {
        if (!$this->hasMoreRequests || $this->loadingMore) {
            return;
        }

        $this->loadingMore = true;
        $this->currentPage++;

        try {
            $method = 'get' . ucfirst($this->activeTab) . 'Data';
            $newRequests = $this->shiftRequestApi->$method($this->currentPage, $this->perPage);
            
            if (!empty($newRequests)) {
                $this->shiftRequests = array_merge($this->shiftRequests, $newRequests);
                $this->hasMoreRequests = count($newRequests) >= $this->perPage;
            } else {
                $this->hasMoreRequests = false;
            }
        } catch (\Exception $e) {
            $this->hasMoreRequests = false;
        }

        $this->loadingMore = false;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->currentPage = 1;
        $this->hasMoreRequests = true;
        $this->loadInitialRequests();
    }

    public function getShiftRequestActions($shiftRequest)
    {
        return [\App\Enum\shiftActions::ACCEPT_SHIFT->value, \App\Enum\shiftActions::DECLINE_SHIFT->value];
    }

    public function getShiftRequestCardOptions($shiftRequest)
    {
        return [
            'type' => 'request',
            'showRequestedBy' => true,
            'showStatus' => true,
            'showCallTime' => true,
            'showVenue' => true,
            'showHourlyRate' => false,
            'showWorkerCount' => false,
        ];
    }

    public function approveRequest($shiftId)
    {
        // Implement approve logic
        $this->dispatch('approveRequest', shiftId: $shiftId);
    }

    public function declineRequest($shiftId)
    {
        // Implement decline logic
        $this->dispatch('declineRequest', shiftId: $shiftId);
    }

    public function render()
    {
        return view('livewire.user.component.shift-requests.shift-requests-list');
    }

    public function placeholder()
    {
        return view('livewire.user.component.shift-requests.shift-requests-list-placeholder');
    }
} 