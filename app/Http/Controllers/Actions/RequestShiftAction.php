<?php

namespace App\Http\Controllers\Actions;

use App\Models\AvailableShift;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;

class RequestShiftAction extends Action
{
    public function setUp(): void
    {
        $this->label(fn(?Model $record) => 'Request');
        $this->color('success');
        $this->record(function (array $arguments) {
            static $cachedShift = null;
    
            if (! $cachedShift && $shiftId = data_get($arguments, 'shift_id')) {
                $cachedShift = AvailableShift::find($shiftId);
            }
    
            return $cachedShift;
        });
        $this->rateLimit(5)
        ->rateLimitedNotification(
           fn (TooManyRequestsException $exception): Notification => Notification::make()
                ->warning()
                ->title('Slow down!')
                ->body("You can try again in {$exception->secondsUntilAvailable} seconds."),
        );
        $this->outlined();
        $this->requiresConfirmation();
        $this->modalWidth('sm');
        $this->modalHeading(fn(?Model $record) => 'Request Shift');
        $this->modalDescription(fn(?Model $record) => 'Request to work @' . ($record->start_time ?? ''));
        $this->modalSubmitActionLabel(fn(?Model $record) => 'Request Shift');
        $this->modalCancelActionLabel(fn(?Model $record) => 'Cancel');
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
        $this->action(function (?Model $record, array $data) {
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