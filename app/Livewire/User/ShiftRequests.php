<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ShiftRequests extends Component
{
    public $activeTab = 'pending';

    public function mount($activeTab = 'pending')
    {
        $this->activeTab = $activeTab;
    }

    public function render()
    {
        return view('livewire.user.shift-requests');
    }
}
