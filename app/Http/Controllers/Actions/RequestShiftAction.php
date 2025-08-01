<?php

namespace App\Http\Controllers\Actions;

use App\Models\AvailableShift;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class RequestShiftAction extends Action
{
    public function setUp(): void
    {
        $this->label(fn(?AvailableShift $record) => 'Request');
        $this->color('success');
        $this->record(function (array $arguments) {
            static $cachedShift = null;
    
            if (! $cachedShift && $shiftId = data_get($arguments, 'shift_id')) {
                $cachedShift = AvailableShift::find($shiftId);
            }
    
            return $cachedShift;
        });
        $this->outlined();
        $this->requiresConfirmation();
        $this->modalWidth('sm');
        $this->modalHeading(fn(?AvailableShift $record) => 'Request Shift');
        $this->modalDescription(fn(?AvailableShift $record) => 'Request to work @' . ($record->start_time ?? ''));
        $this->modalSubmitActionLabel(fn(?AvailableShift $record) => 'Request Shift');
        $this->modalCancelActionLabel(fn(?AvailableShift $record) => 'Cancel');
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
        $this->action(function (?AvailableShift $record, array $data) {
            if (!$record) {
                return;
            }
            
            // TODO: Implement actual request functionality
            // This would typically call an API endpoint to request the shift
            $reason = $data['reason'] ?? '';
            $this->dispatch('request-shift', ['availableShiftId' => $record->api_id ?? $record->id, 'reason' => $reason]);
        });
    }

    public function getDefaultView(): string|null
    {
        return 'filament::components.button.index';
    }
}