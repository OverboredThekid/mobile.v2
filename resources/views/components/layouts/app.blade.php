<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="application-name" content="{{ config('app.name') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>{{ config('app.name') }}</title>
    
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    
    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="antialiased bg-gray-950 text-white">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - Converted to Blade component -->
        @include('components.sidebar')
        
        <!-- Main content area -->
        <div class="flex-1 flex flex-col overflow-hidden md:ml-0">
            <!-- Main content -->
            <main class="flex-1 overflow-y-auto pb-24 pt-5 px-4 md:px-6">
                @hasSection('content')
                    @yield('content')
                @else
                {{ $slot }}
                @endif
            </main>
            
            <!-- Footer - Converted to Blade component -->
            @include('components.footer')
        </div>
    </div>
    
    @livewire('notifications')
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    
    <!-- Fix for Leaflet marker icons -->
    <script>
        // Fix for default markers in Leaflet
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        });
    </script>
    
    @filamentScripts
    @vite('resources/js/app.js')
    
    @stack('scripts')
</body>
</html>
