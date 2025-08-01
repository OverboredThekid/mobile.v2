@props([
    'coordinates' => [37.7749, -122.4194],
    'venueName' => 'Unknown Venue',
    'venueAddress' => '',
    'height' => '192px',
    'mapId' => 'map',
    'showOpenInMapsButton' => true
])

<div class="w-full bg-gray-800 rounded-2xl overflow-hidden relative" style="height: {{ $height }};">
    <div wire:ignore>
        <div id="{{ $mapId }}" 
             style="height: {{ $height }}; width: 100%;" 
             class="rounded-2xl"
             data-lat="{{ $coordinates[0] }}" 
             data-lng="{{ $coordinates[1] }}" 
             data-venue-name="{{ $venueName }}"
             data-venue-address="{{ $venueAddress }}">
        </div>
    </div>
    
    <!-- Open in Maps Button Overlay -->
    @if($showOpenInMapsButton)
        <button
            x-data
            x-on:click="window.open(getNativeMapsLink({ lat: {{ $coordinates[0] }}, lng: {{ $coordinates[1] }}, label: '{{ $venueName }}' }), '_blank')"
            class="absolute top-2 right-2 btn btn-sm btn-primary shadow-lg gap-1"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 616 0z" />
            </svg>
            Open in Maps
        </button>
    @endif
</div>

@push('scripts')
@script
<script>
    const mapContainer = document.getElementById('{{ $mapId }}');
    if (mapContainer) {
        const lat = parseFloat(mapContainer.dataset.lat);
        const lng = parseFloat(mapContainer.dataset.lng);
        const venueName = mapContainer.dataset.venueName;
        const venueAddress = mapContainer.dataset.venueAddress;

        // Initialize map with venue coordinates
        const map = L.map('{{ $mapId }}', {
            center: [lat, lng],
            zoom: 15,
            scrollWheelZoom: false,
            zoomControl: true
        });

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Create marker at venue location
        const marker = L.marker([lat, lng]).addTo(map);

        // Add popup with venue information
        let popupContent = `<div class="text-center">
            <div class="font-semibold text-gray-900">${venueName}</div>`;
        if (venueAddress) {
            popupContent += `<div class="text-sm text-gray-600 mt-1">${venueAddress.replace(/\n/g, '<br>')}</div>`;
        }
        popupContent += '</div>';
        
        marker.bindPopup(popupContent);

        // Handle map resize after a short delay to ensure proper loading
        setTimeout(() => {
            map.invalidateSize();
        }, 200);

        // Additional resize handling for modal context
        setTimeout(() => {
            map.invalidateSize();
        }, 500);
    }

    // Native maps link function (only define if not already defined)
    if (typeof getNativeMapsLink === 'undefined') {
        window.getNativeMapsLink = function(params) {
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            
            if (isMobile) {
                // Use native maps app
                return 'maps://maps.apple.com/?q=' + params.label + '&ll=' + params.lat + ',' + params.lng;
            } else {
                // Use Google Maps web
                return 'https://www.google.com/maps/search/?api=1&query=' + params.lat + ',' + params.lng;
            }
        };
    }
</script>
@endscript
@endpush 