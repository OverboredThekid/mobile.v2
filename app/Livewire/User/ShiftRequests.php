<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ShiftRequests extends Component
{
    public function render()
    {
        return view('livewire.user.shift-requests');
    }
}
