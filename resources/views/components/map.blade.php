@props([
    'coordinates' => [37.7749, -122.4194],
    'venueName' => 'Unknown Venue',
    'venueAddress' => '',
    'height' => '192px',
    'mapId' => 'map',
    'showOpenInMapsButton' => true
])

<div class="w-full bg-gray-800 rounded-2xl overflow-hidden relative z-9" style="height: {{ $height }};">
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