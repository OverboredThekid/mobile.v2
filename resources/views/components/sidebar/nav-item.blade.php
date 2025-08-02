@props([
    'icon',
    'route',
    'label',
    'color' => 'gray',
    'badgeId' => null,
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
    class="flex items-center justify-between px-3 py-2 text-sm rounded-lg transition-colors duration-150 {{ $isActive ? 'bg-gray-800 text-white font-semibold' : 'text-gray-300' }}">
    
    <div class="flex items-center gap-2">
        <x-dynamic-component :component="$icon" class="w-5 h-5 text-{{ $color }}-400" />
        <span>{{ $label }}</span>
    </div>

    @if ($badgeId)
        <span id="{{ $badgeId }}" class="text-xs bg-{{ $color }}-600 text-white rounded-full px-2 py-0.5 hidden"></span>
    @endif
</a>
