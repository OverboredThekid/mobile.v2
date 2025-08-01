<?php

namespace App\Http\Controllers\Actions;

use App\Models\ShiftRequest;
use Filament\Actions\Action;

class AcceptShiftAction extends Action
{
    public function setUp(): void
    {
        $this->label(fn(?ShiftRequest $record) => 'Accept');
        $this->color('success');
        $this->record(function (array $arguments) {
            static $cachedShiftRequest = null;

            if (! $cachedShiftRequest && $shiftRequestId = data_get($arguments, 'shift_id')) {
                $cachedShiftRequest = ShiftRequest::find($shiftRequestId);
            }

            return $cachedShiftRequest;
        });
        $this->requiresConfirmation();
        $this->modalHeading(fn(?ShiftRequest $record) => 'Accept Shift');
        $this->modalDescription(fn(?ShiftRequest $record) => 'Are you sure you want to accept this shift?');
        $this->modalCancelActionLabel(fn(?ShiftRequest $record) => 'Cancel');
        $this->modalSubmitActionLabel(fn(?ShiftRequest $record) => 'Accept');
        $this->modalWidth('sm');
        $this->action(function (?ShiftRequest $record, array $arguments) {
            dd($arguments);
            if (!$record) {
                return;
            }
            
            // TODO: Implement actual accept functionality
            // This would typically call an API endpoint to accept the shift
            $this->dispatch('accept-shift', ['shiftRequestId' => $record->api_id ?? $record->id]);
        });
    }

    public function getDefaultView(): string|null
    {
        return 'filament::components.button.index';
    }
}