<?php

namespace App\Livewire\Ui\Modal;

use Livewire\Component;
use Livewire\Attributes\On;

class Demo extends Component
{
    public $currentHalfScreenChild = '';
    public $currentHalfScreenSize = '50';
    public $currentFullScreenModalChild = '';
    public $currentFullScreenModalTitle = '';
    public $showHalfScreen = false;
    public $showFullScreenModal = false;

    public function openHalfScreen($params)
    {
        $this->currentHalfScreenChild = $params['child'] ?? '';
        $this->currentHalfScreenSize = $params['size'] ?? '50';
        $this->showHalfScreen = true;
    }

    public function openFullScreenModal($params)
    {
        $this->currentFullScreenModalChild = $params['child'] ?? '';
        $this->currentFullScreenModalTitle = $params['title'] ?? '';
        $this->showFullScreenModal = true;
    }

    #[On('halfscreen-closed')]
    public function closeHalfScreen()
    {
        $this->showHalfScreen = false;
    }

    #[On('fullscreenmodal-closed')]
    public function closeFullScreenModal()
    {
        $this->showFullScreenModal = false;
    }

    public function render()
    {
        return view('livewire.ui.modal.demo');
    }
} 