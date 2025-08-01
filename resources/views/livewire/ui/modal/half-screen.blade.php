<div x-data="{
    show: @entangle('show'),
    currentHeight: @entangle('currentHeight'),
    startY: 0,
    startHeight: 0,
    isDragging: false,
    snapPoints: [25, 50, 75, 95],
    minHeight: 25,
    maxHeight: 95, // Prevent going above screen
    dragThreshold: 80, // pixels to drag down to close - less aggressive
    closeThreshold: 15, // percentage of screen height to close
    
    init() {
        this.currentHeight = {{ $currentHeight }};
    },
    
    toggleHeight() {
        this.currentHeight = this.currentHeight < 60 ? 95 : 25;
    },
    
    startDrag(event) {
        this.isDragging = true;
        this.startY = event.type === 'touchstart' ? event.touches[0].clientY : event.clientY;
        this.startHeight = this.currentHeight;
        document.addEventListener('mousemove', this.handleDrag.bind(this));
        document.addEventListener('mouseup', this.stopDrag.bind(this));
        document.addEventListener('touchmove', this.handleDrag.bind(this));
        document.addEventListener('touchend', this.stopDrag.bind(this));
    },
    
    handleDrag(event) {
        if (!this.isDragging) return;
        
        const currentY = event.type === 'touchmove' ? event.touches[0].clientY : event.clientY;
        const deltaY = currentY - this.startY;
        const heightChange = (deltaY / window.innerHeight) * 100;
        
        // Allow going below minHeight for closing purposes
        const newHeight = Math.max(0, Math.min(this.maxHeight, this.startHeight - heightChange));
        
        this.currentHeight = newHeight;
        
        // Visual feedback for drag direction
        const modal = this.$refs.modal;
        if (modal) {
            if (deltaY > 0 && newHeight < this.closeThreshold) {
                // Only show close indicator when very close to bottom
                modal.style.opacity = Math.max(0.3, 1 - (deltaY / 200));
            } else {
                // Normal opacity
                modal.style.opacity = 1;
            }
        }
    },
    
    stopDrag(event) {
        this.isDragging = false;
        document.removeEventListener('mousemove', this.handleDrag.bind(this));
        document.removeEventListener('mouseup', this.stopDrag.bind(this));
        document.removeEventListener('touchmove', this.handleDrag.bind(this));
        document.removeEventListener('touchend', this.stopDrag.bind(this));
        
        const currentY = event.type === 'touchend' ? event.changedTouches[0].clientY : event.clientY;
        const deltaY = currentY - this.startY;
        
        // Reset opacity
        const modal = this.$refs.modal;
        if (modal) {
            modal.style.opacity = 1;
        }
        
        // Check if we should close first
        if (this.currentHeight < this.closeThreshold && deltaY > this.dragThreshold) {
            this.close();
            return;
        }
        
        // Otherwise snap to nearest point
        this.snapToNearest();
    },
    
    snapToNearest() {
        const nearest = this.snapPoints.reduce((prev, curr) => {
            return Math.abs(curr - this.currentHeight) < Math.abs(prev - this.currentHeight) ? curr : prev;
        });
        
        this.currentHeight = nearest;
        $wire.currentHeight = nearest;
    },
    
    close() {
        this.show = false;
        this.currentHeight = {{ $this->getHeightFromSize($size) }};
        $wire.close();
    }
}" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full"
    x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="fixed inset-0 z-50"
    style="display: none;" @keydown.escape="close()">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/30 " @click="close()"></div>
    
    <!-- Modal Container -->
    <div x-ref="modal"
         class="absolute bottom-0 left-0 right-0 bg-gray-900 rounded-t-2xl shadow-2xl transform transition-all duration-300 ease-out flex flex-col"
         :style="`height: ${currentHeight}vh;`">
        
        <!-- Drag Handle Area -->
        <div class="relative h-16 flex items-center justify-center cursor-grab active:cursor-grabbing bg-gray-800 rounded-t-2xl flex-shrink-0"
             @mousedown="startDrag($event)" @touchstart="startDrag($event)">

            <!-- Drag Indicator -->
            <div class="w-16 h-1.5 bg-gray-500 rounded-full shadow-sm"></div>

            <!-- Controls (Expand + Close) -->
            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center gap-3">
                <!-- Expand/Collapse Button -->
                <button @click="toggleHeight"
                    class="p-2.5 rounded-md bg-gray-700 hover:bg-gray-600 transition-all duration-200">
                    <template x-if="currentHeight < 60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                    </template>
                    <template x-if="currentHeight >= 60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </template>
                </button>

                <!-- Close Button -->
                <button @click="close()"
                    class="p-2.75 rounded-md bg-gray-700 hover:bg-gray-600 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-900 min-h-0">
            @if($child)
                @if(!empty($childParams))
                    @livewire($child, $childParams)
                @else
                    @livewire($child)
                @endif
            @else
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Details</h3>
                    <p class="text-gray-400">Content goes here...</p>
                </div>
            @endif
        </div>
    </div>
</div>