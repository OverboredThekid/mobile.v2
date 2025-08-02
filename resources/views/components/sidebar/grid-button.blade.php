@props([
    'icon',
    'route',
    'label',
])

@php
    $isActive = request()->routeIs($route);
@endphp

<a wire:navigate
    href="{{ route($route) }}"
    x-data="{ pressed: false }"
    @touchstart="pressed = true"
    @touchend="pressed = false"
    :class="pressed ? 'bg-gray-700' : '{{ $isActive ? 'bg-gray-800' : 'hover:bg-gray-800' }}'"
    class="flex flex-col items-center justify-center p-4 rounded-lg transition-colors duration-150 {{ $isActive ? 'bg-gray-800 text-white font-semibold' : 'text-gray-300' }}">
    
    <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mb-2">
        <x-dynamic-component :component="$icon" class="w-5 h-5 text-gray-300" />
    </div>
    
    <span class="text-sm font-medium">{{ $label }}</span>
</a>
