@php
    use \App\Enum\shiftActions;
@endphp
@if($loading)
    <!-- Loading State -->
    <div class="animate-pulse space-y-4">
        <div class="h-48 bg-gray-800 rounded-2xl"></div>
        <div class="px-4 space-y-3">
            <div class="h-8 bg-gray-800 rounded"></div>
            <div class="h-6 bg-gray-800 rounded w-3/4"></div>
            <div class="h-4 bg-gray-800 rounded w-1/2"></div>
        </div>
        <div class="flex justify-center">
            <div class="loading loading-spinner loading-lg"></div>
        </div>
    </div>
@elseif($shift)
    <!-- Shift Details -->
    <div class="space-y-4">
        <!-- Map Section -->
        <x-map 
            :coordinates="$coordinates"
            :venueName="$venueDto ? $venueDto->getDisplayName() : 'Unknown Venue'"
            :venueAddress="$addressString"
            height="192px"
            mapId="shift-map"
            :showOpenInMapsButton="$this->hasValidVenueLocation()"
        />
        <!-- Title and Venue Information -->
        <div class="px-4 space-y-3">
            <h1 class="text-2xl font-bold text-white mb-1">
                {{ $shift['title'] ?? 'Untitled Shift' }}
            </h1>
            <p class="text-base text-gray-400 mb-3">
                {{ $shift['schedule_title'] ?? 'Loading...' }}
            </p>
            
            <!-- Venue Information -->
            @if($this->hasVenue())
                <div class="space-y-3">
                    {{ ($this->getShiftAction(shiftActions::VENUE_DETAILS->value))(['venue_id' => $shift['venue']['id']]) }}
                     <x-filament-actions::modals />
                    <!-- Venue Type Badges -->
                    @if(!empty($venueDto->venue_type))
                        <div class="flex flex-wrap gap-2">
                            @foreach($venueDto->venue_type as $type)
                                <div class="badge {{ $venueDto->getColorClass() }} text-white text-xs">
                                    {{ ucfirst($type) }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Venue Address -->
                    @if($addressString)
                        <div class="text-sm text-gray-400">
                            {{ $addressString }}
                        </div>
                    @endif
                    
                    <!-- Venue Description -->
                    @if($venueDto->venue_comment)
                        <div class="text-sm text-gray-400 bg-gray-800 rounded-lg p-3">
                            {{ $venueDto->venue_comment }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Schedule Information -->
        <div class="px-4 space-y-1">
            <p class="text-white text-base">
                {{ $this->getFormattedDate() }}
            </p>
            <p class="text-white text-base">
                {{ $this->getFormattedTime() }}
            </p>
            @if($this->getFormattedCallTime())
                <p class="text-gray-400 text-base">
                    Call Time: {{ $this->getFormattedCallTime() }}
                </p>
            @endif
        </div>

        <!-- Dynamic Tabs -->
        @include('user.components.shift.tabs', [
            'activeTab' => $activeTab,
            'shift' => $shift,
            'loading' => $loading,
            'hasNotes' => $this->hasNotes(),
            'hasWorkers' => $this->hasWorkers(),
            'hasPunches' => $this->hasTimePunches(),
            'hasShiftNotes' => $this->hasShiftNotes(),
            'hasDocuments' => $this->hasDocuments()
        ])

        <!-- Action Buttons -->
@else
    <!-- Error State -->
    <div class="text-center py-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
        </svg>
        <p class="text-gray-400 mb-4">Unable to load shift details</p>
        <button wire:click="refreshData" class="btn btn-primary">
            Try Again
        </button>
    </div>
@endif
