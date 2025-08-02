<?php

namespace App\Http\Controllers\Actions;

use App\Services\ModelAutoResolver;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use App\Traits\HasShiftActions;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Notifications\Notification;
class ShiftDetailsAction extends Action
{
    use HasShiftActions;
    public function setUp(): void
    {
        $this->hiddenLabel();
        $this->color(color: 'transparent');
        $this->icon('heroicon-o-chevron-right');
        $this->rateLimit(15)
        ->rateLimitedNotification(
           fn (TooManyRequestsException $exception): Notification => Notification::make()
                ->warning()
                ->title('Slow down!')
                ->body("You can try again in {$exception->secondsUntilAvailable} seconds."),
        );
        $this->slideOver();
        $this->extraModalFooterActions(function (array $arguments, $record): array {
            return collect($arguments['Actions'] ?? [])
                ->map(fn($action) => $this->getShiftAction($action, $record)->slideOver())
                ->values()
                ->all();
        });
        $this->modalContent(function (Model $record): View {
            $shiftData = collect($record->toArray())
                ->map(function ($value, $key) {
                    $jsonFields = ['workers', 'venue', 'shift_request', 'documents', 'time_punches'];
                    if (in_array($key, $jsonFields) && is_string($value)) {
                        $decoded = json_decode($value, true);
                        return $decoded !== null ? $decoded : $value;
                    }
                    return $value;
                })
                ->toArray();
            return view('filament.actions.shift-details-modal', [
                'shiftData' => $shiftData,
            ]);
        });
       
        $this->modalCancelAction(false);
        $this->modalSubmitAction(false);
        $this->record(
            function (array $arguments) {
                $id = $arguments['shift_id'] ?? null;

                if (! $id) {
                    return null;
                }

                return app(ModelAutoResolver::class)->resolve($id);
            }
        );
    }

    public function getDefaultView(): string|null
    {
        return 'filament::components.button.index';
    }
}
