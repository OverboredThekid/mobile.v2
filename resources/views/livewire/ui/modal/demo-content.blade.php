<div class="p-6 space-y-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-white mb-2">Demo Content</h2>
        <p class="text-gray-400">This is sample content inside the modal</p>
    </div>

    <!-- Sample Form -->
    <div class="bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-white mb-4">Sample Form</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                <input type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                <textarea rows="4" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                Submit
            </button>
        </div>
    </div>

    <!-- Sample List -->
    <div class="bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-white mb-4">Sample List</h3>
        <div class="space-y-2">
            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                <span class="text-white">Item 1</span>
                <span class="text-green-400 text-sm">Active</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                <span class="text-white">Item 2</span>
                <span class="text-yellow-400 text-sm">Pending</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                <span class="text-white">Item 3</span>
                <span class="text-red-400 text-sm">Inactive</span>
            </div>
        </div>
    </div>

    <!-- Sample Stats -->
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-gray-800 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-blue-400">1,234</div>
            <div class="text-sm text-gray-400">Total Items</div>
        </div>
        <div class="bg-gray-800 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-400">567</div>
            <div class="text-sm text-gray-400">Active Items</div>
        </div>
    </div>

    <!-- Interactive Elements -->
    <div class="bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-white mb-4">Interactive Elements</h3>
        <div class="space-y-3">
            <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                Success Action
            </button>
            <button class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                Warning Action
            </button>
            <button class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                Danger Action
            </button>
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-white mb-4">Scrollable Content</h3>
        <div class="space-y-2 max-h-32 overflow-y-auto">
            @for($i = 1; $i <= 20; $i++)
                <div class="p-2 bg-gray-700 rounded text-sm text-gray-300">
                    Scrollable item {{ $i }}
                </div>
            @endfor
        </div>
    </div>
</div> 