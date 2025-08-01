<div
    x-data="{
        activeTab: getActiveTab(window.location.pathname),
        init() {
            window.addEventListener('popstate', () => {
                this.activeTab = getActiveTab(window.location.pathname);
            });
            window.addEventListener('livewire:navigated', () => {
                this.activeTab = getActiveTab(window.location.pathname);
            });
        }
    }"
    class="fixed bottom-0 left-0 right-0 md:left-80 z-40"
>
    <script>
        function getActiveTab(path) {
            if (path === '/' || path === '/dashboard') return 'home';
            if (path.startsWith('/chat')) return 'chat';
            if (path.startsWith('/my-shifts') || path.startsWith('/shifts')) return 'my-shifts';
            return 'home';
        }
    </script>

    <div class="mx-4 mb-6 bg-gray-900/95 backdrop-blur-lg rounded-2xl border border-gray-700 shadow-2xl">
        <nav class="flex items-center justify-around">

            <!-- Home -->
            <a href="{{ route('dashboard') }}"
                @click="activeTab = 'home'"
                :class="activeTab === 'home' ? 'text-white' : 'text-gray-500'"
                class="flex flex-col items-center px-1 py-2 transition-all duration-200 hover:text-gray-300"
            >
                <div :class="activeTab === 'home' ? 'bg-white/20 scale-110' : 'bg-transparent scale-100'"
                     class="p-2 rounded-xl transition-all duration-200">
                    <x-heroicon-o-home class="w-6 h-6" />
                </div>
                <span class="text-xs font-medium mt-1">Home</span>
            </a>

            <!-- Chat -->
            <a href="{{ route('chat') }}"
                @click="activeTab = 'chat'"
                :class="activeTab === 'chat' ? 'text-white' : 'text-gray-500'"
                class="flex flex-col items-center px-1 py-2 transition-all duration-200 hover:text-gray-300"
            >
                <div :class="activeTab === 'chat' ? 'bg-white/20 scale-110' : 'bg-transparent scale-100'"
                     class="p-2 rounded-xl transition-all duration-200">
                    <x-heroicon-o-chat-bubble-oval-left class="w-6 h-6" />
                </div>
                <span class="text-xs font-medium mt-1">Chat</span>
            </a>

            <!-- My Shifts -->
            <a href="{{ route('my-shifts') }}"
                @click="activeTab = 'my-shifts'"
                :class="activeTab === 'my-shifts' ? 'text-white' : 'text-gray-500'"
                class="flex flex-col items-center px-1 py-2 transition-all duration-200 hover:text-gray-300"
            >
                <div :class="activeTab === 'my-shifts' ? 'bg-white/20 scale-110' : 'bg-transparent scale-100'"
                     class="p-2 rounded-xl transition-all duration-200">
                    <x-heroicon-o-calendar class="w-6 h-6" />
                </div>
                <span class="text-xs font-medium mt-1">My Shifts</span>
            </a>

        </nav>
    </div>
</div> 