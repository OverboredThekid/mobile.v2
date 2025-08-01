<?php

namespace App\Http\Controllers\Actions;

use App\Models\Shift;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class BailoutAction extends Action
{
    public function setUp(): void
    {
        $this->label(fn(?Shift $record) => 'Bailout');
        $this->color('danger');
        $this->record(function (array $arguments) {
            static $cachedShift = null;
    
            if (! $cachedShift && $shiftId = data_get($arguments, 'shift_id')) {
                $cachedShift = Shift::find($shiftId);
            }
    
            return $cachedShift;
        });
        $this->outlined();
        $this->requiresConfirmation();
        $this->modalHeading(fn(?Shift $record) => 'Bailout Shift');
        $this->modalDescription(fn(?Shift $record) => 'Are you sure you want to bailout this shift?');
        $this->modalCancelActionLabel(fn(?Shift $record) => 'Cancel');
        $this->modalSubmitActionLabel(fn(?Shift $record) => 'Bailout');
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
        $this->action(function (?Shift $record, array $data) {
            if (!$record) {
                return;
            }
            
            // TODO: Implement actual bailout functionality
            // This would typically call an API endpoint to bailout
            $reason = $data['reason'] ?? '';
            $this->dispatch('bailout', ['shiftId' => $record->api_id ?? $record->id, 'reason' => $reason]);
        });
    }

    public function getDefaultView(): string|null
    {
        return 'filament::components.button.index';
    }
}