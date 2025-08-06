<div class="bg-base-200 rounded-2xl overflow-hidden animate-pulse">
    <div class="p-4">
        <!-- Calendar Header Skeleton -->
        <div class="flex justify-between items-center mb-6">
            <div class="h-5 w-5 bg-base-300 rounded"></div>
            <div class="flex items-center gap-2">
                <div class="h-6 w-24 bg-base-300 rounded"></div>
            </div>
            <div class="h-5 w-5 bg-base-300 rounded"></div>
        </div>

        <!-- Days of the week skeleton -->
        <div class="grid grid-cols-7 gap-1 mb-6">
            @for($i = 0; $i < 7; $i++)
                <div class="text-center py-3 px-1 rounded-xl bg-base-100">
                    <div class="h-3 bg-base-300 rounded mb-1"></div>
                    <div class="h-5 bg-base-300 rounded"></div>
                </div>
            @endfor
        </div>

        <!-- Selected date events skeleton -->
        <div class="bg-base-100 rounded-2xl p-4">
            <div class="h-6 w-32 bg-base-300 rounded mb-4"></div>
            
            <div class="space-y-3">
                <!-- Shift card skeleton -->
                <div class="card bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-700">
                    <div class="card-body p-6 pr-4">
                        <!-- Header Section -->
                        <div class="grid grid-cols-5 gap-6 mb-4">
                            <div class="col-span-3">
                                <div class="h-6 w-32 bg-base-300 rounded mb-2"></div>
                                <div class="h-4 w-24 bg-base-300 rounded"></div>
                            </div>
                            <div class="col-span-2 flex items-start justify-end gap-2">
                                <div class="h-6 w-16 bg-base-300 rounded"></div>
                                <div class="h-6 w-6 bg-base-300 rounded"></div>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="grid grid-cols-5 gap-6 items-start">
                            <div class="col-span-3 space-y-2">
                                <div>
                                    <div class="h-5 w-20 bg-base-300 rounded mb-2"></div>
                                    <div class="h-6 w-24 bg-base-300 rounded mb-2"></div>
                                    <div class="h-4 w-16 bg-base-300 rounded"></div>
                                </div>
                                <div class="space-y-2">
                                    <div class="h-4 w-20 bg-base-300 rounded"></div>
                                </div>
                            </div>
                            <div class="col-span-1 flex flex-col gap-5 min-w-25 text-center">
                                <div class="h-8 w-16 bg-base-300 rounded"></div>
                                <div class="h-8 w-16 bg-base-300 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 