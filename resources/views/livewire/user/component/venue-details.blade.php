<div class="space-y-4 p-6 pb-8">
    @php
        $venue = $this->getVenueDto();
        $coordinates = $venue->getCoordinates();
    @endphp

    <!-- Venue Map -->
    <x-map 
        :coordinates="$coordinates"
        :venueName="$venue->getDisplayName()"
        :venueAddress="$venue->address"
        height="256px"
        mapId="venue-map"
        :showOpenInMapsButton="$venue->hasValidLocation()"
    />
    
    <!-- Venue Name -->
    <div>
        <h2 class="text-2xl font-bold text-white">
            {{ $venue->getDisplayName() }}
        </h2>
    </div>

    <!-- Venue Type Badges -->
    @if(!empty($venue->venue_type))
        <div class="flex flex-wrap gap-2">
            @foreach($venue->venue_type as $type)
                <div class="badge {{ $venue->getColorClass() }} text-white">
                    {{ ucfirst($type) }}
                </div>
            @endforeach
        </div>
    @endif
    
    <!-- Address -->
    @if($venue->address)
        <div class="mt-2">
            <p class="text-gray-400">{{ $venue->address }}</p>
        </div>
    @endif

    <!-- Description -->
    @if($venue->venue_comment)
        <div class="divider border-gray-700"></div>
        <div>
            <h3 class="text-lg font-semibold mb-2 text-white">Description</h3>
            <p class="text-gray-400">
                {{ $venue->venue_comment }}
            </p>
        </div>
    @endif
    
    <!-- Open in Maps Button -->
    <div class="divider border-gray-700"></div>
    <div>
        <h3 class="text-lg font-semibold mb-2 text-white">Directions</h3>
<x-filament::button 
    x-data 
    x-on:click="window.open(getNativeMapsLink({ lat: {{ $coordinates[0] }}, lng: {{ $coordinates[1] }}, label: '{{ $venue->getDisplayName() }}' }), '_blank')" 
    class="w-full"
    icon="heroicon-o-map-pin"
>
    {{ $venue->hasValidLocation() ? 'Open in Maps' : 'Location Not Available' }}
</x-filament::button>
    </div>
</div>
