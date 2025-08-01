<?php

namespace App\Livewire\Ui\Modal;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class FullScreenModal extends Component
{
    public $child = '';
    public $title = '';
    public $show = true; // Always show when component is rendered
    public $currentHeight = 100; // Always 100% for fullscreen
    public $childParams = [];

    public function mount($child = '', $title = '', ...$params)
    {
        $this->child = $child;
        $this->title = $title;
        $this->currentHeight = 100; // Always full height
        $this->childParams = $params;
    }

    public function close()
    {
        $this->show = false;
        $this->currentHeight = 100;
        // Notify parent component with simple event name
        $this->dispatch('modal-closed')->to('*');
        
        // Debug: Log the event dispatch
        Log::info('FullScreenModal: close() called, dispatching modal-closed event globally');
    }

    public function updateHeight($height)
    {
        $this->currentHeight = $height;
    }

    private function getHeightFromSize($size)
    {
        return 100; // Always 100% for fullscreen
    }

    public function render()
    {
        return view('livewire.ui.modal.full-screen-modal');
    }
}
