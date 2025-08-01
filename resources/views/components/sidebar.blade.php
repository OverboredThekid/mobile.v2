@php
    $user = app(\App\Services\AuthApiService::class)->getStoredUser();
@endphp

<div x-data="sidebar()" class="relative flex">
    <!-- Mobile backdrop overlay -->
    <div x-show="sidebarOpen" x-transition.opacity.duration.300ms @click="sidebarOpen = false"
        class="fixed inset-0 bg-opacity-50 z-40 md:hidden"></div>

    <!-- Sidebar -->
    <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
        class="fixed top-0 left-0 z-50 h-full w-80 bg-gray-900 text-white transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col border-r border-gray-800 -translate-x-full md:translate-x-0">
        <!-- Mobile: starts off-screen, desktop: always visible -->

        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-800">
            <h1 class="text-xl font-semibold">{{ config('app.name') }}</h1>
            <button @click="sidebarOpen = false" class="md:hidden p-2 rounded-lg hover:bg-gray-800">
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>

        <!-- Scrollable content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Priority Section -->
            <div class="px-6 py-4">
                <nav class="space-y-1">
                    <a href="{{ route('shift-requests') }}"
                        class="group flex items-center justify-between px-3 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <div class="flex items-center">
                            <x-heroicon-o-calendar class="w-5 h-5 text-red-400 mr-3" />
                            <span>Shift Requests</span>
                        </div>
                        <span id="shift-requests-count" class="bg-red-500 text-white text-xs px-2 py-1 rounded-full hidden">0</span>
                    </a>
                    <a href="{{ route('available-shifts') }}"
                        class="group flex items-center justify-between px-3 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <div class="flex items-center">
                            <x-heroicon-o-clock class="w-5 h-5 text-yellow-400 mr-3" />
                            <span>Available Shifts</span>
                        </div>
                        <span id="available-shifts-count" class="bg-yellow-500 text-black text-xs px-2 py-1 rounded-full hidden">0</span>
                    </a>
                </nav>
            </div>

            <!-- Company Section -->
            <div class="px-6 py-4">
                <h2 class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3">Company</h2>
                <nav class="grid grid-cols-2 gap-3">
                    <a href="{{ route('blog') }}"
                        class="flex flex-col items-center justify-center p-4 rounded-lg hover:bg-gray-800 transition-colors">
                        <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mb-2">
                            <x-heroicon-o-document-text class="w-5 h-5 text-gray-300" />
                        </div>
                        <span class="text-sm font-medium">Blog</span>
                    </a>
                    <a href="{{ route('faq') }}"
                        class="flex flex-col items-center justify-center p-4 rounded-lg hover:bg-gray-800 transition-colors">
                        <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mb-2">
                            <x-heroicon-o-question-mark-circle class="w-5 h-5 text-gray-300" />
                        </div>
                        <span class="text-sm font-medium">FAQ</span>
                    </a>
                    <a href="{{ route('resources') }}"
                        class="flex flex-col items-center justify-center p-4 rounded-lg hover:bg-gray-800 transition-colors">
                        <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mb-2">
                            <x-heroicon-o-book-open class="w-5 h-5 text-gray-300" />
                        </div>
                        <span class="text-sm font-medium">Resources</span>
                    </a>
                    <a href="{{ route('contacts') }}"
                        class="flex flex-col items-center justify-center p-4 rounded-lg hover:bg-gray-800 transition-colors">
                        <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mb-2">
                            <x-heroicon-o-users class="w-5 h-5 text-gray-300" />
                        </div>
                        <span class="text-sm font-medium">Contacts</span>
                    </a>
                </nav>
            </div>

            <!-- Manage Section -->
            <div class="px-6 py-4">
                <h2 class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3">Manage</h2>
                <nav class="space-y-1">
                    <a href="{{ route('time-off') }}"
                        class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <x-heroicon-o-calendar-days class="w-5 h-5 text-green-400 mr-3" />
                        <span>Time Off</span>
                    </a>
                    <a href="{{ route('availability') }}"
                        class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-green-400 mr-3" />
                        <span>Availability</span>
                    </a>
                </nav>
            </div>

            <!-- Admin Section -->
            <div class="px-6 py-4">
                <h2 class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3">Admin</h2>
                <nav class="space-y-1">
                    <a href="{{ route('manage-punches') }}"
                        class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <x-heroicon-o-finger-print class="w-5 h-5 text-purple-400 mr-3" />
                        <span>Manage Punches</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- User Profile Section (Bottom) -->
        <div class="border-t border-gray-800 p-6">
            <!-- User Info -->
            @if($user)
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-white">{{ substr($user['name'] ?? 'U', 0, 1) }}</span>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-white">{{ $user['name'] ?? 'User' }}</p>
                        <p class="text-xs text-gray-400">{{ $user['email'] ?? 'user@example.com' }}</p>
                    </div>
                    <button class="p-1 rounded-lg hover:bg-gray-800">
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" />
                    </button>
                </div>
            @else
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-white">?</span>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-white">Loading...</p>
                        <p class="text-xs text-gray-400">Fetching user data</p>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('my-hours') }}"
                    class="flex items-center justify-center px-4 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <x-heroicon-o-clock class="w-4 h-4 mr-2" />
                    <span class="text-sm font-medium">My Hours</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4 mr-2" />
                        <span class="text-sm font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile toggle button -->
    <button @click="sidebarOpen = !sidebarOpen" x-show="!sidebarOpen"
        class="fixed top-4 right-4 z-50 p-2 rounded-lg bg-gray-900 text-white md:hidden">
        <x-heroicon-o-bars-3 class="w-6 h-6" />
    </button>

    <script>
        function sidebar() {
            return {
                sidebarOpen: false, // Start closed on mobile to prevent flash

                init() {
                    // Handle window resize
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 768) {
                            this.sidebarOpen = true;
                        } else {
                            this.sidebarOpen = false;
                        }
                    });

                    // Set initial state based on screen size
                    if (window.innerWidth >= 768) {
                        this.sidebarOpen = true;
                    }

                    // Load counts in background using the correct endpoint
                    this.loadCounts();
                },

                async loadCounts() {
                    try {
                        // Use the correct endpoint that exists
                        const response = await fetch('/api/dashboard/counts');
                        if (response.ok) {
                            const data = await response.json();
                            
                            // Update UI
                            const shiftRequestsElement = document.getElementById('shift-requests-count');
                            const availableShiftsElement = document.getElementById('available-shifts-count');

                            if (shiftRequestsElement && data.shift_requests_count > 0) {
                                shiftRequestsElement.textContent = data.shift_requests_count;
                                shiftRequestsElement.classList.remove('hidden');
                            }

                            if (availableShiftsElement && data.available_shifts_count > 0) {
                                availableShiftsElement.textContent = data.available_shifts_count;
                                availableShiftsElement.classList.remove('hidden');
                            }
                        }
                    } catch (error) {
                        console.error('Failed to load counts:', error);
                    }
                }
            }
        }
    </script>
</div> 