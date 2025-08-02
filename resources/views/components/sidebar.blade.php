@php
    $user = app(\App\Services\AuthApiService::class)->getStoredUser();
@endphp

<div x-data="{ sidebarOpen: false }" class="relative flex">
    <!-- Overlay -->
    <div 
        x-show="sidebarOpen"
        x-cloak
        x-transition.opacity.duration.200ms
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-38 md:hidden"
    ></div>

    <!-- Sidebar -->
    <aside
        x-cloak
        x-show="sidebarOpen || window.innerWidth >= 768"
        x-transition:enter="transition transform ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform ease-in duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed md:relative top-0 left-0 z-39 w-80 h-full bg-[#0D0D0D] text-white border-r border-gray-800 flex flex-col transform md:translate-x-0 transition-transform duration-300 ease-in-out"
    >
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
            <h1 class="text-lg font-semibold tracking-tight text-white">{{ config('app.name') }}</h1>
            <button @click="sidebarOpen = false" class="md:hidden p-2 rounded-md hover:bg-gray-800">
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto space-y-6 py-4">
            <!-- Pinned Buttons -->
            <div class="px-6">
                <div class="space-y-3">
                    <x-sidebar.nav-item icon="heroicon-o-calendar" route="shift-requests" color="red" label="Shift Requests" badge-id="shift-requests-count" />
                    <x-sidebar.nav-item icon="heroicon-o-clock" route="available-shifts" color="yellow" label="Available Shifts" badge-id="available-shifts-count" />
                </div>
            </div>

            <!-- Grid Navigation -->
            <div class="px-6">
                <h2 class="text-xs text-gray-500 uppercase mb-3">Company</h2>
                <div class="grid grid-cols-2 gap-4">
                    <x-sidebar.grid-button icon="heroicon-o-document-text" route="blog" label="Blog" />
                    <x-sidebar.grid-button icon="heroicon-o-question-mark-circle" route="faq" label="FAQ" />
                    <x-sidebar.grid-button icon="heroicon-o-book-open" route="resources" label="Resources" />
                    <x-sidebar.grid-button icon="heroicon-o-users" route="contacts" label="Contacts" />
                </div>
            </div>

            <!-- Management -->
            <div class="px-6">
                <h2 class="text-xs text-gray-500 uppercase mb-3">Manage</h2>
                <div class="space-y-3">
                    <x-sidebar.nav-item icon="heroicon-o-calendar-days" route="time-off" color="green" label="Time Off" />
                    <x-sidebar.nav-item icon="heroicon-o-check-circle" route="availability" color="green" label="Availability" />
                </div>
            </div>

            <!-- Admin -->
            <div class="px-6">
                <h2 class="text-xs text-gray-500 uppercase mb-3">Admin</h2>
                <x-sidebar.nav-item icon="heroicon-o-finger-print" route="manage-punches" color="purple" label="Manage Punches" />
            </div>
        </div>

        <!-- User Profile -->
        <div class="border-t border-gray-800 p-6 space-y-4">
            @if($user)
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-sm font-bold text-white">
                        {{ substr($user['name'] ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold">{{ $user['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $user['email'] }}</p>
                    </div>
                    <button class="p-1 hover:bg-gray-800 rounded">
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" />
                    </button>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('my-hours') }}" class="flex justify-center items-center gap-1 px-3 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-sm">
                    <x-heroicon-o-clock class="w-4 h-4" /> My Hours
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex justify-center items-center gap-1 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                        <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4" /> Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile Toggle -->
    <button 
        x-show="!sidebarOpen"
        x-cloak
        @click="sidebarOpen = !sidebarOpen"
        class="fixed top-4 right-4 z-40 p-2 rounded-md bg-[#0D0D0D] text-white md:hidden"
    >
        <x-heroicon-o-bars-3 class="w-6 h-6" />
    </button>
</div>
