<?php

namespace App\Http\Controllers\Actions;

use App\Models\ShiftRequest;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class DeclineShiftAction extends Action
{
    public function setUp(): void
    {
        $this->label(fn(?ShiftRequest $record) => 'Decline');
        $this->color('danger');
        $this->record(function (array $arguments) {
            static $cachedShiftRequest = null;

            if (! $cachedShiftRequest && $shiftRequestId = data_get($arguments, 'shift_id')) {
                $cachedShiftRequest = ShiftRequest::find($shiftRequestId);
            }

            return $cachedShiftRequest;
        });
        $this->requiresConfirmation();
        $this->modalHeading(fn(?ShiftRequest $record) => 'Decline Shift');
        $this->modalDescription(fn(?ShiftRequest $record) => 'Are you sure you want to decline this shift?');
        $this->modalCancelActionLabel(fn(?ShiftRequest $record) => 'Cancel');
        $this->modalSubmitActionLabel(fn(?ShiftRequest $record) => 'Decline');
        $this->modalWidth('sm');
        $this->schema([
            Section::make('Reason (Optional)')
                ->schema([
                    TextInput::make('reason')
                        ->label('Reason')
                        ->required()
                        ->maxLength(255),
                ])->collapsed(true)
                ->contained(false),
        ]);
        $this->action(function (?ShiftRequest $record, array $data) {
            if (!$record) {
                return;
            }
            
            // TODO: Implement actual decline functionality
            // This would typically call an API endpoint to decline the shift
            $reason = $data['reason'] ?? '';
            $this->dispatch('decline-shift', ['shiftRequestId' => $record->api_id ?? $record->id, 'reason' => $reason]);
        });
    }

    public function getDefaultView(): string|null
    {
        return 'filament::components.button.index';
    }
}
