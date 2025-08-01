<div class="pt-4 md:p-6 space-y-6" 
     x-data="{ 
         observer: null,
         init() {
             this.observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting && $wire.hasMoreShifts && !$wire.loadingMore) {
                         $wire.loadMoreShifts();
                     }
                 });
             }, { threshold: 0.1 });
             
             this.$nextTick(() => {
                 const sentinel = this.$refs.sentinel;
                 if (sentinel) {
                     this.observer.observe(sentinel);
                 }
             });
         },
         destroy() {
             if (this.observer) {
                 this.observer.disconnect();
             }
         }
     }"
     x-init="init()"
     @destroy="destroy()"
>
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">My Shifts</h1>
            <p class="text-gray-400">Manage your scheduled shifts</p>
        </div>
    </div>

    <!-- Tabs -->
    <x-filament::tabs class="bg-transparent">
        <x-filament::tabs.item 
            :active="$activeTab === 'all'"
            wire:click="setActiveTab('all')"
        >
            All
        </x-filament::tabs.item>
        
        <x-filament::tabs.item 
            :active="$activeTab === 'upcoming'"
            wire:click="setActiveTab('upcoming')"
        >
            UpComing
        </x-filament::tabs.item>
        
        <x-filament::tabs.item 
            :active="$activeTab === 'past'"
            wire:click="setActiveTab('past')"
        >
            Past
        </x-filament::tabs.item>
    </x-filament::tabs>

    @if($loading && count($shifts) === 0)
        <!-- Initial Loading State -->
        <div class="text-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div>
            <p class="text-gray-400 mt-2">Loading shifts...</p>
        </div>
    @elseif(count($shifts) > 0)
        <!-- Shifts List -->
        <div class="space-y-4">
            @foreach($shifts as $shift)
                @php
                    $actions = [\App\Enum\shiftActions::PUNCH->value, \App\Enum\shiftActions::BAILOUT->value];
                    $options = [
                        'type' => 'shift',
                        'showRequestedBy' => false,
                        'showStatus' => true,
                        'showCallTime' => true,
                        'showVenue' => true,
                        'showHourlyRate' => false,
                        'showWorkerCount' => true,
                    ];
                @endphp
                
                <livewire:user.component.shift-card 
                    :shift="$shift" 
                    :actions="$actions" 
                    :options="$options" 
                    :wire:key="'shift-' . $shift['api_id']"
                />
            @endforeach
            
            <!-- Load More Sentinel -->
            @if($hasMoreShifts)
                <div x-ref="sentinel" class="py-4">
                    @if($loadingMore)
                        <div class="text-center">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500 mx-auto"></div>
                            <p class="text-gray-400 mt-2 text-sm">Loading more shifts...</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-lg font-medium text-white mb-2">
                @if($activeTab === 'all')
                    No shifts found
                @elseif($activeTab === 'upcoming')
                    No upcoming shifts
                @elseif($activeTab === 'past')
                    No past shifts
                @else
                    No shifts scheduled
                @endif
            </h3>
            <p class="text-gray-400">
                @if($activeTab === 'all')
                    You don't have any shifts at the moment.
                @elseif($activeTab === 'upcoming')
                    You don't have any upcoming shifts at the moment.
                @elseif($activeTab === 'past')
                    You don't have any past shifts.
                @else
                    You don't have any shifts scheduled at the moment.
                @endif
            </p>
        </div>
    @endif
</div> 