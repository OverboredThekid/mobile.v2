@props([
    'icon',
    'route',
    'label',
    'color' => 'gray',
    'badgeId' => null,
    'badgeCount' => 0,
])

@php
    $isActive = request()->routeIs($route);
    
    // Map color to badge background color
    $badgeColor = match($color) {
        'red' => 'bg-red-600',
        'yellow' => 'bg-yellow-600',
        'green' => 'bg-green-600',
        'blue' => 'bg-blue-600',
        'purple' => 'bg-purple-600',
        default => 'bg-gray-600'
    };
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

    @if ($badgeId && $badgeCount > 0)
        <span id="{{ $badgeId }}" class="text-xs {{ $badgeColor }} text-white rounded-full px-2 py-0.5 font-bold min-w-[1.25rem] text-center">
            {{ $badgeCount }}
        </span>
    @endif
</a>
