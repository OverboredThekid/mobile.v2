<div class="p-6 space-y-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-white mb-4">Modal Components Demo</h1>
        <p class="text-gray-400">Interactive examples of HalfScreen and FullScreen modals</p>
    </div>

    <!-- HalfScreen Modal Examples -->
    <div class="space-y-6">
        <h2 class="text-2xl font-semibold text-white">HalfScreen Modals</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- 25% Height -->
            <div class="bg-gray-800 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-2">25% Height</h3>
                <p class="text-gray-400 text-sm mb-4">Small modal for quick actions</p>
                <button 
                    wire:click="openHalfScreen({child: 'ui.modal.demo-content', size: '25'})"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Open 25% Modal
                </button>
            </div>

            <!-- 50% Height -->
            <div class="bg-gray-800 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-2">50% Height</h3>
                <p class="text-gray-400 text-sm mb-4">Standard modal size</p>
                <button 
                    wire:click="openHalfScreen({child: 'ui.modal.demo-content', size: '50'})"
                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Open 50% Modal
                </button>
            </div>

            <!-- 75% Height -->
            <div class="bg-gray-800 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-2">75% Height</h3>
                <p class="text-gray-400 text-sm mb-4">Large modal for detailed content</p>
                <button 
                    wire:click="openHalfScreen({child: 'ui.modal.demo-content', size: '75'})"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Open 75% Modal
                </button>
            </div>
        </div>
    </div>

    <!-- FullScreen Modal Examples -->
    <div class="space-y-6">
        <h2 class="text-2xl font-semibold text-white">FullScreen Modals</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Basic FullScreen -->
            <div class="bg-gray-800 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-2">Basic FullScreen</h3>
                <p class="text-gray-400 text-sm mb-4">Slide in from right with drag handles</p>
                <button 
                    wire:click="openFullScreenModal({child: 'ui.modal.demo-content', title: 'Basic FullScreen'})"
                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Open FullScreen
                </button>
            </div>

            <!-- FullScreen with Custom Title -->
            <div class="bg-gray-800 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-2">Custom Title</h3>
                <p class="text-gray-400 text-sm mb-4">FullScreen with custom title</p>
                <button 
                    wire:click="openFullScreenModal({child: 'ui.modal.demo-content', title: 'Custom Title Modal'})"
                    class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Open with Custom Title
                </button>
            </div>
        </div>
    </div>

    <!-- Features Overview -->
    <div class="bg-gray-800 rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-white mb-4">Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-white mb-2">HalfScreen Features</h3>
                <ul class="text-gray-400 space-y-1 text-sm">
                    <li>• Slide up from bottom animation</li>
                    <li>• Draggable height adjustment</li>
                    <li>• Expand/collapse functionality</li>
                    <li>• Configurable sizes (25%, 50%, 75%)</li>
                    <li>• Drag handle with visual indicator</li>
                    <li>• Close on drag down</li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white mb-2">FullScreen Features</h3>
                <ul class="text-gray-400 space-y-1 text-sm">
                    <li>• Slide in from right animation</li>
                    <li>• Drag handles on left and right</li>
                    <li>• Snapchat-style swipe to close</li>
                    <li>• Custom title support</li>
                    <li>• Responsive design</li>
                    <li>• Keyboard escape support</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Usage Examples -->
    <div class="bg-gray-800 rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-white mb-4">Usage Examples</h2>
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-white mb-2">HalfScreen Usage</h3>
                <pre class="bg-gray-900 p-4 rounded-lg text-sm text-gray-300 overflow-x-auto">
&lt;livewire:ui.modal.halfscreen 
    :child="'user.component.shift-details'" 
    :size="'50'" 
/&gt;</pre>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white mb-2">FullScreen Usage</h3>
                <pre class="bg-gray-900 p-4 rounded-lg text-sm text-gray-300 overflow-x-auto">
&lt;livewire:ui.modal.full-screen-modal 
    :child="'user.component.shift-details'" 
    :title="'Shift Details'" 
/&gt;</pre>
            </div>
        </div>
    </div>

    <!-- Conditionally Render Modal Components -->
    @if($showHalfScreen)
        <livewire:ui.modal.halfscreen 
            :child="$currentHalfScreenChild" 
            :size="$currentHalfScreenSize" 
        />
    @endif
    
    @if($showFullScreenModal)
        <livewire:ui.modal.full-screen-modal 
            :child="$currentFullScreenModalChild" 
            :title="$currentFullScreenModalTitle" 
            :key="'demo-fullscreen-modal-' . ($currentFullScreenModalTitle ?? 'default')" 
            wire:key="demo-fullscreen-modal-{{ $currentFullScreenModalTitle ?? 'default' }}" 
        />
    @endif
</div> 