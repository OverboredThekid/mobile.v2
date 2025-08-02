<div class="fixed bottom-0 left-0 right-0 md:left-80 z-37">
    <div class="mx-4 mb-6 bg-[#0D0D0D]/95 backdrop-blur-lg rounded-2xl border border-gray-800 shadow-xl">
        <nav class="flex items-center justify-between">
            @php
                $items = [
                    ['label' => 'Home', 'icon' => 'heroicon-o-home', 'route' => 'dashboard'],
                    ['label' => 'Chat', 'icon' => 'heroicon-o-chat-bubble-oval-left', 'route' => 'chat'],
                    ['label' => 'My Shifts', 'icon' => 'heroicon-o-calendar', 'route' => 'my-shifts'],
                ];
            @endphp

            @foreach ($items as $item)
                @php
                    $isActive = request()->routeIs($item['route']);
                @endphp

                <a
                    wire:navigate
                    href="{{ route($item['route']) }}"
                    x-data="{ pressed: false }"
                    @touchstart="pressed = true"
                    @touchend="pressed = false"
                    :class="{
                        'text-white': {{ $isActive ? 'true' : 'false' }},
                        'text-gray-400 hover:text-gray-200': {{ $isActive ? 'false' : 'true' }}
                    }"
                    class="flex flex-1 flex-col items-center py-2 transition-all duration-150 ease-in-out"
                >
                    <div
                        :class="pressed ? 'bg-white/10 scale-95' : '{{ $isActive ? 'bg-white/10 backdrop-blur-sm shadow-inner scale-110' : 'hover:bg-white/5' }}'"
                        class="p-2 rounded-2xl transition-all duration-200 ease-in-out"
                    >
                        <x-dynamic-component :component="$item['icon']" class="w-6 h-6" />
                    </div>
                    <span class="text-[11px] font-medium mt-1 tracking-tight">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>
</div>
