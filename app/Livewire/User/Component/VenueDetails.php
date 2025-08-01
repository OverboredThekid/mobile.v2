<?php

namespace App\Livewire\User\Component;

use App\Http\Dto\VenueDto;
use Livewire\Component;

class VenueDetails extends Component
{
    public $venue;

    public function mount($venue = null)
    {
        $this->venue = $venue ? is_array($venue) ? $venue : [] : [];
    }

    public function getVenueDto(): VenueDto
    {
        return VenueDto::fromArray($this->venue);
    }

    public function openInMaps()
    {
        $venueDto = $this->getVenueDto();
        
        if (!$venueDto->hasValidLocation()) {
            $this->dispatch('show-notification', [
                'type' => 'warning',
                'message' => 'Location coordinates not available for this venue.'
            ]);
            return;
        }

        $coordinates = $venueDto->getCoordinates();
        $lat = $coordinates[0];
        $lng = $coordinates[1];
        $venueName = urlencode($venueDto->getDisplayName());

        // Create Google Maps URL that works across platforms
        $mapsUrl = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}&query_place_id={$venueName}";

        $this->dispatch('open-external-url', ['url' => $mapsUrl]);
    }

    public function render()
    {
        return view('livewire.user.component.venue-details');
    }
}
