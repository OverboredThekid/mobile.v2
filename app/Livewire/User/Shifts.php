<?php

namespace App\Livewire\User;

use App\Services\AuthApiService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Shifts extends Component
{
    public $user = null;
    public $activeTab = 'upcoming';

    protected AuthApiService $authService;

    public function boot(AuthApiService $authService)
    {
        $this->authService = $authService;
    }

    public function mount()
    {
        // Load user data
        $this->user = $this->authService->getStoredUser();
    }

    public function render()
    {
        return view('livewire.user.shifts');
    }
}
