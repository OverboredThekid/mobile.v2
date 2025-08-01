<div class="p-4 md:p-6 space-y-6">
    <!-- Header Placeholder -->
    <div class="flex items-center justify-between">
        <div>
            <div class="h-8 w-48 bg-gray-700 rounded animate-pulse"></div>
            <div class="h-4 w-64 bg-gray-700 rounded animate-pulse mt-2"></div>
        </div>
    </div>

    <!-- Tabs Placeholder -->
    <div class="flex space-x-4">
        <div class="h-10 w-16 bg-gray-700 rounded animate-pulse"></div>
        <div class="h-10 w-24 bg-gray-700 rounded animate-pulse"></div>
        <div class="h-10 w-16 bg-gray-700 rounded animate-pulse"></div>
    </div>

    <!-- Content Placeholder -->
    <div class="space-y-4">
        @for($i = 0; $i < 3; $i++)
            <div class="bg-gray-800 rounded-lg p-6 animate-pulse">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-6 w-32 bg-gray-700 rounded"></div>
                    <div class="h-6 w-20 bg-gray-700 rounded"></div>
                </div>
                <div class="space-y-3">
                    <div class="h-4 w-full bg-gray-700 rounded"></div>
                    <div class="h-4 w-3/4 bg-gray-700 rounded"></div>
                    <div class="h-4 w-1/2 bg-gray-700 rounded"></div>
                </div>
            </div>
        @endfor
    </div>
</div> 