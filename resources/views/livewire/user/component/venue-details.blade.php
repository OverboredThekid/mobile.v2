<div class="space-y-4 pb-8">
    <!-- Venue Map -->
    <x-map 
        :coordinates="$coordinates"
        :venueName="$venueDto->getDisplayName()"
        :venueAddress="$addressString"
        height="256px"
        mapId="venue-map"
        :showOpenInMapsButton="$venueDto->hasValidLocation()"
    />
    
    <!-- Venue Name -->
    <div>
        <h2 class="text-2xl font-bold text-white">
            {{ $venueDto->getDisplayName() }}
        </h2>
    </div>

    <!-- Venue Type Badges -->
    @if(!empty($venueDto->venue_type))
        <div class="flex flex-wrap gap-2">
            @foreach($venueDto->venue_type as $type)
                <div class="badge {{ $venueDto->getColorClass() }} text-white">
                    {{ ucfirst($type) }}
                </div>
            @endforeach
        </div>
    @endif
    
    <!-- Address -->
    @if($addressString)
        <div class="mt-2">
            <p class="text-gray-400">{{ $addressString }}</p>
        </div>
    @endif

    <!-- Description -->
    @if($venueDto->venue_comment)
        <div class="divider border-gray-700"></div>
        <div>
            <h3 class="text-lg font-semibold mb-2 text-white">Description</h3>
            <p class="text-gray-400">
                {{ $venueDto->venue_comment }}
            </p>
        </div>
    @endif
    
    <!-- Open in Maps Button -->
    @if($venueDto->hasValidLocation())
        <div class="divider border-gray-700"></div>
        <div>
            <h3 class="text-lg font-semibold mb-2 text-white">Directions</h3>
            <x-filament::button 
                x-data 
                x-on:click="window.open(getNativeMapsLink({ lat: {{ $coordinates[0] }}, lng: {{ $coordinates[1] }}, label: '{{ $venueDto->getDisplayName() }}' }), '_blank')" 
                class="w-full"
                icon="heroicon-o-map-pin"
            >
                Open in Maps
            </x-filament::button>
        </div>
    @endif
</div>
