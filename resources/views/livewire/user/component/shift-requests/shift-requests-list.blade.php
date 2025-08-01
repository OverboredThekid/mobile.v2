<div class="pt-4 md:p-6 space-y-6" 
     x-data="{ 
         observer: null,
         init() {
             this.observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting && $wire.hasMoreRequests && !$wire.loadingMore) {
                         $wire.loadMoreRequests();
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
            <h1 class="text-2xl font-bold text-white">Shift Requests</h1>
            <p class="text-gray-400">Review and manage shift requests</p>
        </div>
    </div>

    @if($loading && count($shiftRequests) === 0)
        <!-- Initial Loading State -->
        <div class="text-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div>
            <p class="text-gray-400 mt-2">Loading shift requests...</p>
        </div>
    @elseif(count($shiftRequests) > 0)
        <!-- Shift Requests List -->
        <div class="space-y-4">
            @foreach($shiftRequests as $shiftRequest)
                @php
                    $actions = $this->getShiftRequestActions($shiftRequest);
                    $options = $this->getShiftRequestCardOptions($shiftRequest);
                @endphp
                
                <livewire:user.component.shift-card 
                    :shift="$shiftRequest" 
                    :actions="$actions" 
                    :options="$options" 
                    :wire:key="'request-' . $shiftRequest['api_id']"
                />
            @endforeach
            
            <!-- Load More Sentinel -->
            @if($hasMoreRequests)
                <div x-ref="sentinel" class="py-4">
                    @if($loadingMore)
                        <div class="text-center">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500 mx-auto"></div>
                            <p class="text-gray-400 mt-2 text-sm">Loading more requests...</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-lg font-medium text-white mb-2">
                No shift requests
            </h3>
            <p class="text-gray-400">
                You don't have any shift requests at the moment.
            </p>
        </div>
    @endif
</div> 