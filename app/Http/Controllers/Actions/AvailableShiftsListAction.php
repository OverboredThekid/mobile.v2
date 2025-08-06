<?php

namespace App\Http\Controllers\Actions;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class AvailableShiftsListAction extends Action
{
    public function setUp(): void
    {
        $this->hiddenLabel();
        $this->slideOver();
        $this->modalContent(fn() => view('filament.actions.available-shift-list-modal'));

        $this->modalCancelAction(false);
        $this->modalSubmitAction(false);
        $this->rateLimit(5)
        ->rateLimitedNotification(
           fn (TooManyRequestsException $exception): Notification => Notification::make()
                ->warning()
                ->title('Slow down!')
                ->body("You can try again in {$exception->secondsUntilAvailable} seconds."),
        );
    }
}