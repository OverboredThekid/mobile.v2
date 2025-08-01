<?php

namespace App\Traits;

trait HasShiftDetailsModal
{
    public $showShiftDetailsModal = false;
    public $currentShiftData = null;

    public function openShiftDetailsModal($shiftData = null)
    {
        // Convert complex data to simple array, similar to venue pattern
        if ($shiftData) {
            // Use provided shift data converted to array
            $this->currentShiftData = is_array($shiftData) ? $shiftData : (array) $shiftData;
        } elseif (isset($this->shift)) {
            // Use current component's shift data
            $this->currentShiftData = is_array($this->shift) ? $this->shift : (array) $this->shift;
        }

        $this->showShiftDetailsModal = true;
    }
} 