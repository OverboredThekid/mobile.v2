<?php

namespace App\Http\Controllers\Actions;

use App\Models\ShiftRequest;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class AcceptShiftAction extends Action
{
    public function setUp(): void
    {
        $this->label(fn(?Model $record) => 'Accept');
        $this->color('success');
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
        $this->modalHeading(fn(?Model $record) => 'Accept Shift');
        $this->modalDescription(fn(?Model $record) => 'Are you sure you want to accept this shift?');
        $this->modalCancelActionLabel(fn(?Model $record) => 'Cancel');
        $this->modalSubmitActionLabel(fn(?Model $record) => 'Accept');
        $this->modalWidth('sm');
        $this->action(function (?Model $record, array $arguments) {
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