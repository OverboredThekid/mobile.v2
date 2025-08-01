<div x-data="{
    show: @entangle('show'),
    currentHeight: @entangle('currentHeight'),
    startX: 0,
    offset: 0,
    isDragging: false,
    dragDirection: null, // 'left' or 'right'
    screenWidth: window.innerWidth,
    
    init() {
        this.currentHeight = 100; // Always start at 100%
        this.screenWidth = window.innerWidth;
        
        // Watch for modal closing and dispatch event
        this.$watch('show', (value) => {
            if (!value) {
                if (window.Livewire) {
                    window.Livewire.dispatch('modal-closed');
                }
            }
        });
    },
    
    startDrag(event) {
        const touchX = event.type === 'touchstart' ? event.touches[0].clientX : event.clientX;
        
        // Check if touch started from edge (within 15px of either edge)
        const isLeftEdge = touchX < 15;
        const isRightEdge = touchX > this.screenWidth - 15;
        const isEdge = isLeftEdge || isRightEdge;
        
        if (!isEdge) return; // Only allow dragging from edges
        
        this.isDragging = true;
        this.startX = touchX;
        this.offset = 0;
        this.dragDirection = isLeftEdge ? 'left' : 'right';
        
        document.addEventListener('mousemove', this.handleDrag.bind(this));
        document.addEventListener('mouseup', this.stopDrag.bind(this));
        document.addEventListener('touchmove', this.handleDrag.bind(this));
        document.addEventListener('touchend', this.stopDrag.bind(this));
    },
    
    handleDrag(event) {
        if (!this.isDragging) return;
        
        const currentX = event.type === 'touchmove' ? event.touches[0].clientX : event.clientX;
        const deltaX = currentX - this.startX;
        
        // Determine direction based on which edge we started from
        if (this.dragDirection === 'left') {
            // From left edge, allow only right swipes (positive delta)
            if (deltaX > 0) {
                this.offset = deltaX;
            }
        } else {
            // From right edge, allow only left swipes (negative delta)
            if (deltaX < 0) {
                this.offset = deltaX;
            }
        }
        
        // Visual feedback for drag direction
        const modal = this.$refs.modal;
        if (modal) {
            const absOffset = Math.abs(this.offset);
            const fadeProgress = Math.min(absOffset / (this.screenWidth * 0.7), 1);
            const opacity = 1 - fadeProgress * 0.7; // Keep some opacity (0.3) even at full swipe
            modal.style.opacity = opacity;
        }
    },
    
    stopDrag(event) {
        if (!this.isDragging) return;
        
        this.isDragging = false;
        document.removeEventListener('mousemove', this.handleDrag.bind(this));
        document.removeEventListener('mouseup', this.stopDrag.bind(this));
        document.removeEventListener('touchmove', this.handleDrag.bind(this));
        document.removeEventListener('touchend', this.stopDrag.bind(this));
        
        const currentX = event.type === 'touchend' ? event.changedTouches[0].clientX : event.clientX;
        const deltaX = currentX - this.startX;
        
        // Reset opacity
        const modal = this.$refs.modal;
        if (modal) {
            modal.style.opacity = 1;
        }
        
        // Threshold to close is 25% of screen width
        const threshold = this.screenWidth * 0.25;
        
        // Check if we should close based on direction and distance
        let shouldClose = false;
        
        if (this.dragDirection === 'left' && deltaX > threshold) {
            // Close to the right from left edge
            shouldClose = true;
        } else if (this.dragDirection === 'right' && deltaX < -threshold) {
            // Close to the left from right edge
            shouldClose = true;
        }
        
        if (shouldClose) {
            this.close();
            return;
        }
        
        // Otherwise snap back to open
        this.snapToNearest();
    },
    
    snapToNearest() {
        this.offset = 0;
    },
    
    close() {
        this.show = false;
        this.offset = 0;
    },
    
    getTransform() {
        return `translateX(${this.offset}px)`;
    },
    
    getOpacity() {
        if (!this.isDragging && this.offset === 0) return 1;
        
        const absOffset = Math.abs(this.offset);
        const fadeProgress = Math.min(absOffset / (this.screenWidth * 0.7), 1);
        return 1 - fadeProgress * 0.7; // Keep some opacity (0.3) even at full swipe
    }
}" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed inset-0 z-50"
    style="display: none;" @keydown.escape="close()">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/30 " @click="close()"></div>
    
    <!-- Modal Container -->
    <div x-ref="modal"
         class="absolute inset-y-0 right-0 w-full max-w-md bg-gray-900 shadow-2xl transform transition-all duration-300 ease-out flex flex-col"
         :style="`transform: ${getTransform()}; opacity: ${getOpacity()};`">
        
        <!-- Header Area -->
        <div class="relative h-16 flex items-center justify-center bg-gray-800 flex-shrink-0">

            <!-- Title -->
            @if($title)
                <h1 class="text-lg font-semibold text-white">{{ $title }}</h1>
            @else
                <h1 class="text-lg font-semibold text-white">Details</h1>
            @endif

            <!-- Close Button -->
            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
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

        <!-- Left Drag Handle - Full height for easy access -->
        <div class="absolute left-0 top-0 bottom-0 w-4 cursor-ew-resize z-10"
             @mousedown="startDrag($event)" @touchstart="startDrag($event)"></div>

        <!-- Right Drag Handle - Full height for easy access -->
        <div class="absolute right-0 top-0 bottom-0 w-4 cursor-ew-resize z-10"
             @mousedown="startDrag($event)" @touchstart="startDrag($event)"></div>

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