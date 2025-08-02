<div class="fixed bottom-0 left-0 right-0 md:left-80 z-38">
    <div class="mx-4 mb-6 bg-gray-900/95 backdrop-blur-lg rounded-2xl border border-gray-700 shadow-2xl">
        <nav class="flex items-center justify-around">

            <!-- Home -->
            <a href="{{ route('dashboard') }}" wire:navigate.hover wire:current="text-gray-500"
                class="flex flex-col items-center px-1 py-2 transition-all duration-200 hover:text-gray-300">
                <div wire:current="bg-white/20 scale-110"
                    class="p-2 rounded-xl transition-all duration-200">
                    <x-heroicon-o-home class="w-6 h-6" />
                </div>
                <span class="text-xs font-medium mt-1">Home</span>
            </a>

            <!-- Chat -->
            <a href="{{ route('chat') }}" wire:navigate.hover  wire:current="text-gray-500"
                class="flex flex-col items-center px-1 py-2 transition-all duration-200 hover:text-gray-300">
                <div wire:current="bg-white/20 scale-110"
                    class="p-2 rounded-xl transition-all duration-200">
                    <x-heroicon-o-chat-bubble-oval-left class="w-6 h-6" />
                </div>
                <span class="text-xs font-medium mt-1">Chat</span>
            </a>

            <!-- My Shifts -->
            <a href="{{ route('my-shifts') }}" wire:current="text-gray-500"
                wire:navigate.hover
                class="flex flex-col text-white items-center px-1 py-2 transition-all duration-200 hover:text-gray-300">
                <div wire:current="bg-white/20 scale-110"
                    class="p-2 bg-transparent scale-100 rounded-xl transition-all duration-200">
                    <x-heroicon-o-calendar class="w-6 h-6" />
                </div>
                <span class="text-xs font-medium mt-1">My Shifts</span>
            </a>

        </nav>
    </div>
</div>