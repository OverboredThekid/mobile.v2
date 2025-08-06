<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\API\VenuesApi;
use App\Livewire\User\Component\VenueDetails;
use App\Models\Venue;
use App\Services\ModelAutoResolver;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VenueDetailsAction extends Action
{
    public function setUp(): void
    {
        $this->label(fn(?Model $record) => 'Venue Details');
        $this->color('gray');
        $this->icon('heroicon-o-information-circle');
        $this->link();
        $this->rateLimit(5)
        ->rateLimitedNotification(
           fn (TooManyRequestsException $exception): Notification => Notification::make()
                ->warning()
                ->title('Slow down!')
                ->body("You can try again in {$exception->secondsUntilAvailable} seconds."),
        );
        $this->modalContent(function (?Model $record, Component $livewire) {
            // If no record is provided, try to get venue data from the livewire component
            if (!$record) {
                $venueData = $livewire->shift['venue'] ?? null;
                
                if ($venueData) {
                    $venue = Venue::find($venueData['id']);
                    if ($venue) {
                        return view('filament.actions.venue-details-modal', [
                            'venue' => $venue
                        ]);
                    }
                } else {
                    return view('filament.actions.venue-details-modal', [
                        'venue' => null
                    ]);
                }
            } else {
                // Convert the model record to array data with address
                $venueData = $record->toArrayWithAddress();

                // Define JSON fields that need to be decoded
                $jsonFields = ['venue_type', 'venue_color', 'address'];

                // Decode JSON fields using Laravel's collect for efficiency
                $venueData = collect($venueData)->map(function ($value, $key) use ($jsonFields) {
                    if (in_array($key, $jsonFields) && is_string($value)) {
                        $decoded = json_decode($value, true);
                        return $decoded !== null ? $decoded : $value;
                    }
                    return $value;
                })->toArray();
            }

            // Return a view that renders the Livewire component
            return view('filament.actions.venue-details-modal', [
                'venue' => $venueData
            ]);
        });
        $this->modalCancelAction(false);
        $this->modalSubmitAction(false);
        $this->record(function (array $arguments) {
            static $cachedVenue = null;

            if ($cachedVenue) {
                return $cachedVenue;
            }

            $id = $arguments['venue_id'] ?? null;

            if (!$id) {
                return null;
            }

            // First try to find by internal ID
            $cachedVenue = Venue::with('address')->find($id);

            // Then try to find by API ID
            if (!$cachedVenue) {
                $cachedVenue = Venue::with('address')->where('api_id', $id)->first();
            }

            // Finally try to fetch from API
            if (!$cachedVenue) {
                try {
                    $venueData = app(VenuesApi::class)->getItemById($id);

                    if (!empty($venueData)) {
                        $cachedVenue = new Venue();
                        $cachedVenue->fill($venueData);
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to fetch venue from API: " . $e->getMessage());
                }
            }

            return $cachedVenue;
        });
    }

    public function getDefaultView(): string|null
    {
        return 'filament::components.button.index';
    }
}