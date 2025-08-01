<div class="card bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-700 hover:border-gray-600 transition-all duration-200">
    <div class="card-body p-6 pr-4">
        <!-- Header Section -->
        <div class="grid grid-cols-5 gap-6 mb-4">
            <!-- Title + Schedule Info (narrow) -->
            <div class="col-span-3">
                <h3 class="text-lg font-bold text-white mb-1">
                    {{ $shift['title'] }}
                </h3>

                @if($showRequestedBy && $this->getRequestedBy())
                    <p class="text-sm text-gray-400">
                        Requested by {{ $this->getRequestedBy() }}
                    </p>
                @endif

                @if($shift['schedule_title'])
                    <p class="text-sm text-gray-500">
                        {{ $shift['schedule_title'] }}
                    </p>
                @endif
            </div>

            <!-- Status + Details Button (right-aligned) -->
            <div class="col-span-2 flex items-start justify-end gap-2">
                @if($showStatus)
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $this->getStatusColor() }} text-white">
                        {{ $this->getStatusText() }}
                    </span>
                @endif

                <button wire:click="openShiftDetails" class="p-1 rounded-lg hover:bg-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-5 gap-6 items-start">
            <!-- Left Content -->
            <div class="col-span-3 space-y-2">
                <div>
                    <p class="text-white font-semibold mb-2">
                        {{ $this->getFormattedDate() }}
                    </p>
                    <p class="text-white text-lg mb-2">
                        {{ $this->getFormattedTime() }}
                    </p>
                    @if($showCallTime && $this->getFormattedCallTime())
                        <p class="text-gray-400 text-sm">
                            Call Time: {{ $this->getFormattedCallTime() }}
                        </p>
                    @endif
                </div>

                <div class="space-y-2">
                    @if($showVenue && $shift['venue_name'])
                        <div class="flex items-center gap-2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <button 
                                wire:click="openVenueDetails" 
                                class="text-sm hover:text-blue-400 transition-colors underline decoration-dotted underline-offset-2"
                            >
                                {{ $shift['venue_name'] }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Content: Actions -->
            @if(count($actions) > 0)
                <div class="col-span-1 flex flex-col gap-5 min-w-25 text-center" wire:ignore>
                    @foreach($actions as $actionKey)
                        {{ ($this->getShiftAction($actionKey))(['shift_id' => $shift['id']]) }}
                    @endforeach
                </div>
                <x-filament-actions::modals />
            @else
                <div class="col-span-1"></div>
            @endif
        </div>
    </div>

    <!-- HalfScreen Modal for Venue Details -->
    @if($showVenueModal && $currentVenue)
        <livewire:ui.modal.halfscreen 
            :child="'user.component.venue-details'" 
            :size="'75'"
            :venue="$currentVenue"
            :key="'venue-modal-' . ($currentVenue['id'] ?? 'default')"
        />
    @endif

    <!-- FullScreen Modal for Shift Details -->
    @if($showShiftDetailsModal && $currentShiftData)
        <livewire:ui.modal.full-screen-modal 
            :child="'user.component.shift-details'" 
            :title="'Shift Details'"
            :shiftData="$currentShiftData"
            :key="'shift-details-modal-' . ($currentShiftData['api_id'] ?? 'default')"
        />
    @endif
</div>
