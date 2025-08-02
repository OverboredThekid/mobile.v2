<?php

namespace App\Livewire;

use App\Jobs\LoadDashboardCounts;
use App\Services\AuthApiService;
use App\Http\Controllers\API\ShiftRequestApi;
use App\Http\Controllers\API\AvailableShiftsApi;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public ?array $user = null;
    public bool $loading = true;
    public int $shiftRequestsCount = 0;
    public int $availableShiftsCount = 0;
    public bool $countsLoading = false;

    protected AuthApiService $authService;
    protected ShiftRequestApi $shiftRequestApi;
    protected AvailableShiftsApi $availableShiftsApi;

    public function boot(
        AuthApiService $authService,
        ShiftRequestApi $shiftRequestApi,
        AvailableShiftsApi $availableShiftsApi
    ) {
        $this->authService = $authService;
        $this->shiftRequestApi = $shiftRequestApi;
        $this->availableShiftsApi = $availableShiftsApi;
    }

    public function mount()
    {
        // Check if user is authenticated first
        if (!$this->authService->isAuthenticated()) {
            session()->flash('message', 'Please log in to access the dashboard.');
            return $this->redirect('/login', navigate: true);
        }

        $this->loadUserData();
        $this->loadCachedCounts();
    }

    public function loadUserData()
    {
        $this->loading = true;

        // Try to get fresh user data from API
        $this->user = $this->authService->getUser();

        // Fall back to stored user data if API call fails
        if (!$this->user) {
            $this->user = $this->authService->getStoredUser();
        }

        $this->loading = false;
    }

    public function loadCachedCounts()
    {
        // Try to get cached counts first
        $this->shiftRequestsCount = Cache::get('shift_requests_count', 0);
        $this->availableShiftsCount = Cache::get('available_shifts_count', 0);

        // Load fresh counts in background if cache is stale
        if (Cache::missing('shift_requests_count') || Cache::missing('available_shifts_count')) {
            $this->loadCounts();
        }
    }

    public function loadCounts()
    {
        $this->countsLoading = true;

        try {
            // Dispatch background job to load counts
            LoadDashboardCounts::dispatch();
        } catch (\Exception $e) {
            Log::error('Failed to dispatch counts job: ' . $e->getMessage());
            $this->shiftRequestsCount = 0;
            $this->availableShiftsCount = 0;
        } finally {
            $this->countsLoading = false;
        }
    }

    #[On('counts-loaded')]
    public function updateCounts($shiftRequestsCount, $availableShiftsCount)
    {
        $this->shiftRequestsCount = $shiftRequestsCount;
        $this->availableShiftsCount = $availableShiftsCount;
        $this->countsLoading = false;
    }

    public function logout()
    {
        $this->authService->logout();
        session()->flash('message', 'You have been logged out successfully.');
        return $this->redirect('/login', navigate: true);
    }

    public function refreshData()
    {
        $this->loadUserData();
        $this->loadCounts();
        $this->dispatch('user-data-refreshed');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
