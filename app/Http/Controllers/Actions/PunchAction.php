<?php

namespace App\Http\Controllers\Actions;

use App\Models\Shift;
use Filament\Actions\Action;

class PunchAction extends Action
{
    public function setUp(): void
    {
        $this->label(fn(?Shift $record) => 'Punch in/out');
        $this->color('success');
        //$this->disabled(fn(?Shift $record) => !$record->can_punch);
        $this->record(function (array $arguments) {
            static $cachedShift = null;
    
            if (! $cachedShift && $shiftId = data_get($arguments, 'shift_id')) {
                $cachedShift = Shift::find($shiftId);
            }
    
            return $cachedShift;
        });
        $this->outlined();
        $this->requiresConfirmation();
        $this->modalHeading(fn(?Shift $record) => 'Punch In');
        $this->modalDescription(fn(?Shift $record) => 'Are you sure you want to punch in for this shift?');
        $this->modalCancelActionLabel(fn(?Shift $record) => 'Cancel');
        $this->modalSubmitActionLabel(fn(?Shift $record) => 'Punch In');
        $this->modalWidth('sm');
        $this->action(function (?Shift $record, array $arguments) {
            dd($record);
            if (!$record) {
                return;
            }
            
            // TODO: Implement actual punch functionality
            // This would typically call an API endpoint to punch in
            // For now, we'll just dispatch a Livewire event
            $this->dispatch('punch-in', ['shiftId' => $record->api_id ?? $record->id]);
        });
    }

    public function getDefaultView(): string|null
    {
        return 'filament::components.button.index';
    }
}