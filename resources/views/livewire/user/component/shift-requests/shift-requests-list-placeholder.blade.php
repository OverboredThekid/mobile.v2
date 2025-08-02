<div class="pt-4 md:p-6 space-y-6">
    <!-- Header Skeleton -->
    <div class="flex items-center justify-between">
        <div>
            <div class="h-8 w-48 bg-gray-700 rounded mb-2 animate-pulse"></div>
            <div class="h-4 w-64 bg-gray-700 rounded animate-pulse"></div>
        </div>
    </div>

    <!-- Content Skeleton -->
    <div class="space-y-4">
        @for($i = 0; $i < 3; $i++)
            <div class="card bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-700">
                <div class="card-body p-6 pr-4">
                    <div class="grid grid-cols-5 gap-6 mb-4">
                        <div class="col-span-3">
                            <div class="h-6 bg-gray-700 rounded mb-2 animate-pulse"></div>
                            <div class="h-4 bg-gray-700 rounded w-3/4 animate-pulse"></div>
                        </div>
                        <div class="col-span-2 flex items-start justify-end gap-2">
                            <div class="h-6 w-16 bg-gray-700 rounded animate-pulse"></div>
                            <div class="h-6 w-6 bg-gray-700 rounded animate-pulse"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5 gap-6 items-start">
                        <div class="col-span-3 space-y-2">
                            <div class="h-5 bg-gray-700 rounded animate-pulse"></div>
                            <div class="h-6 bg-gray-700 rounded animate-pulse"></div>
                            <div class="h-4 bg-gray-700 rounded w-1/2 animate-pulse"></div>
                        </div>
                        <div class="col-span-2"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div> 