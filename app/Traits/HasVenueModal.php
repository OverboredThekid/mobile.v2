<?php

namespace App\Traits;

use App\Http\Dto\VenueDto;
trait HasVenueModal
{
    public $showVenueModal = false;
    public $currentVenue = null;

    public function openVenueDetails($venueData = null)
    {
        if ($venueData) {
            // Use provided venue data
            $this->currentVenue = VenueDto::fromArray($venueData)->toArray();
        } elseif (isset($this->shift['venue']) && is_array($this->shift['venue'])) {
            // Prefer the venue object from API response (database data)
            $this->currentVenue = VenueDto::fromArray($this->shift['venue'])->toArray();
        } elseif (isset($this->shift)) {
            // Fallback to shift data fields
            $venueArray = [
                'id' => $this->shift['venue_id'] ?? '',
                'venue_name' => $this->shift['venue_name'] ?? 'Unknown Venue',
                'venue_type' => $this->shift['venue_type'] ?? ['hotel'],
                'venue_comment' => $this->shift['venue_comment'] ?? null,
                'address' => $this->shift['venue_address'] ?? null,
                'latitude' => $this->shift['venue_latitude'] ?? null,
                'longitude' => $this->shift['venue_longitude'] ?? null,
            ];
            $this->currentVenue = VenueDto::fromArray($venueArray)->toArray();
        }

        $this->showVenueModal = true;
    }
} 