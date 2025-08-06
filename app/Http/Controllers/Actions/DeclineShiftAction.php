<?php

namespace App\Http\Controllers\Actions;

use App\Models\ShiftRequest;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;

class DeclineShiftAction extends Action
{
    public function setUp(): void
    {
        $this->label(fn(?Model $record) => 'Decline');
        $this->color('danger');
        $this->record(function (array $arguments) {
            static $cachedShiftRequest = null;

            if (! $cachedShiftRequest && $shiftRequestId = data_get($arguments, 'shift_id')) {
                $cachedShiftRequest = ShiftRequest::find($shiftRequestId);
            }

            return $cachedShiftRequest;
        });
        $this->rateLimit(5)
        ->rateLimitedNotification(
           fn (TooManyRequestsException $exception): Notification => Notification::make()
                ->warning()
                ->title('Slow down!')
                ->body("You can try again in {$exception->secondsUntilAvailable} seconds."),
        );
        $this->requiresConfirmation();
        $this->modalHeading(fn(?Model $record) => 'Decline Shift');
        $this->modalDescription(fn(?Model $record) => 'Are you sure you want to decline this shift?');
        $this->modalCancelActionLabel(fn(?Model $record) => 'Cancel');
        $this->modalSubmitActionLabel(fn(?Model $record) => 'Decline');
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
        $this->action(function (?Model $record, array $data) {
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
