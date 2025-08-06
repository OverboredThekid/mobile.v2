<div class="flex justify-center mt-6">
    @php
        $shiftRequestsCount = $this->shiftRequestsCount;
        $availableShiftsCount = $this->availableShiftsCount;
    @endphp

    @if($loading)
        <div class="flex gap-1 w-full max-w-2xl">
            <div class="flex-1 bg-gray-200 animate-pulse rounded-2xl py-4 px-6">
                <div class="flex items-center justify-center gap-2">
                    <div class="h-5 w-5 bg-gray-300 rounded"></div>
                    <div class="h-4 bg-gray-300 rounded w-24"></div>
                </div>
            </div>
            <div class="flex-1 bg-gray-200 animate-pulse rounded-2xl py-4 px-6">
                <div class="flex items-center justify-center gap-2">
                    <div class="h-5 w-5 bg-gray-300 rounded"></div>
                    <div class="h-4 bg-gray-300 rounded w-24"></div>
                </div>
            </div>
        </div>
    @elseif($shiftRequestsCount > 0 || $availableShiftsCount > 0)
        <div class="flex gap-1 w-full max-w-2xl">
            @if($shiftRequestsCount > 0)
                <button
                    wire:click="mountAction('shiftRequestList')"
                    class="flex-1 relative bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 border-t border-red-400/30 border-l-2 border-r-2 border-red-400/50 border-b-4 border-red-700/80"
                   >
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-base">Shift Requests</span>
                    </div>
                    <div
                        class="absolute -top-2 -right-2 bg-white text-red-600 border-2 border-red-600 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $shiftRequestsCount }}
                    </div>
                </button>
            @endif

            @if($availableShiftsCount > 0)
                <button
                    wire:click="mountAction('availableShiftsList')"
                    class="flex-1 relative bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 border-t border-blue-400/30 border-l-2 border-r-2 border-blue-400/50 border-b-4 border-blue-700/80"
                    >
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-base">Available Shifts</span>
                    </div>
                    <div
                        class="absolute -top-2 -right-2 bg-white text-blue-600 border-2 border-blue-600 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $availableShiftsCount }}
                    </div>
                </button>
            @endif
        </div>
    @endif
    <x-filament-actions::modals />
</div>
