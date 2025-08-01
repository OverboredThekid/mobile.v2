<?php

namespace App\Livewire\User\Component;

use App\Enum\shiftActions;
use App\Traits\HasShiftActions;
use App\Traits\HasVenueModal;
use App\Traits\HasShiftDetailsModal;
use Filament\Actions\Action;
use Livewire\Component;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Support\Str;

class ShiftCard extends Component implements HasActions, HasSchemas
{
    use HasShiftActions;
    use HasVenueModal;
    use HasShiftDetailsModal;
    use InteractsWithActions;
    use InteractsWithSchemas;

    public $shift;
    public $actions = [];
    public $showRequestedBy = false;
    public $showStatus = true;
    public $showCallTime = true;
    public $showVenue = true;
    public $showHourlyRate = false;
    public $showWorkerCount = false;
    public $loading = false;

    public function mount($shift, $actions = [], $options = [])
    {
        // Ensure shift is an array
        $this->shift = is_array($shift) ? $shift : [];

        // Set display options based on card type
        $this->showRequestedBy = $options['showRequestedBy'] ?? false;
        $this->showStatus = $options['showStatus'] ?? true;
        $this->showCallTime = $options['showCallTime'] ?? true;
        $this->showVenue = $options['showVenue'] ?? true;
        $this->showHourlyRate = $options['showHourlyRate'] ?? false;
        $this->showWorkerCount = $options['showWorkerCount'] ?? false;

        // Configure actions after properties are set
        $this->configureActions($actions);
    }

    protected function configureActions($actions)
    {
        $this->actions = collect($actions)
            ->map(fn($action) => $action instanceof shiftActions ? $action->value : $action)
            ->toArray();
    }

    public function getStatusColor()
    {
        if (!is_array($this->shift) || !isset($this->shift['status'])) {
            return 'bg-gray-500';
        }

        return match ($this->shift['status']) {
            'confirmed' => 'bg-green-500',
            'pending' => 'bg-yellow-500',
            'declined' => 'bg-red-500',
            'cancelled' => 'bg-gray-500',
            'bailout' => 'bg-red-500',
            'requested' => 'bg-yellow-500',
            default => 'bg-gray-500'
        };
    }

    public function getStatusText()
    {
        if (!is_array($this->shift) || !isset($this->shift['status'])) {
            return '';
        }
        return ucfirst($this->shift['status']);
    }

    public function getFormattedDate()
    {
        if (!is_array($this->shift) || !isset($this->shift['start_time'])) {
            return '';
        }
        return \Carbon\Carbon::parse($this->shift['start_time'], 'UTC')->setTimezone(config('app.timezone'))->format('l, F j, Y');
    }

    public function getFormattedTime()
    {
        if (!is_array($this->shift) || !isset($this->shift['start_time']) || !isset($this->shift['end_time'])) {
            return '';
        }
        $start = \Carbon\Carbon::parse($this->shift['start_time'], 'UTC')->setTimezone(config('app.timezone'))->format('g:i A');
        $end = \Carbon\Carbon::parse($this->shift['end_time'], 'UTC')->setTimezone(config('app.timezone'))->format('g:i A');
        return "{$start} - {$end}";
    }

    public function getFormattedCallTime()
    {
        if (!is_array($this->shift) || !isset($this->shift['call_time']) || !$this->shift['call_time']) {
            return null;
        }
        
        if (!isset($this->shift['start_time'])) {
            return null;
        }
        
        $startTime = \Carbon\Carbon::parse($this->shift['start_time'], 'UTC')->setTimezone(config('app.timezone'))->subMinutes($this->shift['call_time']);
        return $startTime->format('g:i A');
    }

    public function getRequestedBy()
    {
        if (!is_array($this->shift)) {
            return null;
        }
        
        if (isset($this->shift['shift_request']) && is_array($this->shift['shift_request'])) {
            return $this->shift['shift_request']['requested_by'] ?? null;
        }
        return $this->shift['requested_by'] ?? null;
    }

    public function openShiftDetails()
    {
        // Ensure we have valid shift data
        if (!is_array($this->shift) || empty($this->shift)) {
            return;
        }

        // Add meta timestamp to track data freshness
        $shiftData = array_merge($this->shift, [
            'meta_updated_at' => now()->toISOString()
        ]);

        // Open the modal with the shift data
        $this->openShiftDetailsModal($shiftData);
    }
    public function render()
    {
        return view('livewire.user.component.shift-card');
    }
}
