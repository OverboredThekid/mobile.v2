<?php

namespace App\Livewire\Ui\Modal;

use Livewire\Component;

class HalfScreen extends Component
{
    public $child = '';
    public $size = '50'; // 25, 50, 75
    public $show = true; // Always show when component is rendered
    public $currentHeight = 0;
    public $childParams = [];

    public function mount($child = '', $size = '50', ...$params)
    {
        $this->child = $child;
        $this->size = $size;
        $this->currentHeight = $this->getHeightFromSize($size);
        $this->childParams = $params;
    }

    public function close()
    {
        $this->show = false;
        $this->currentHeight = $this->getHeightFromSize($this->size);
        // Notify parent component
        $this->dispatch('halfscreen-closed');
    }

    public function updateHeight($height)
    {
        $this->currentHeight = $height;
    }

    private function getHeightFromSize($size)
    {
        return match($size) {
            '25' => 25,
            '75' => 75,
            default => 50
        };
    }

    public function render()
    {
        return view('livewire.ui.modal.half-screen');
    }
}
