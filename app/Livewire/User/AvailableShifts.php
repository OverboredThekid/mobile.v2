<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class AvailableShifts extends Component
{
    public function render()
    {
        return view('livewire.user.available-shifts');
    }
}
