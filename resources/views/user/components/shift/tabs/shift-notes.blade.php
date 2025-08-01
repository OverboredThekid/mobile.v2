@if($loading)
    <div class="animate-pulse space-y-4">
        <div class="h-4 bg-gray-800 rounded"></div>
        <div class="h-4 bg-gray-800 rounded w-3/4"></div>
        <div class="h-20 bg-gray-800 rounded-lg"></div>
    </div>
@elseif($shift)
    @if(isset($shift['notes_admin']) || isset($shift['notes_worker']))
        <div class="space-y-3">
            @if(isset($shift['notes_admin']) && $shift['notes_admin'])
                <div class="space-y-2">
                    <span class="text-gray-400 text-sm font-medium">Admin Notes</span>
                    <p class="text-white text-sm bg-gray-800 rounded-lg p-3">
                        {{ $shift['notes_admin'] }}
                    </p>
                </div>
            @endif
            
            @if(isset($shift['notes_worker']) && $shift['notes_worker'])
                <div class="space-y-2">
                    <span class="text-gray-400 text-sm font-medium">Worker Notes</span>
                    <p class="text-white text-sm bg-gray-800 rounded-lg p-3">
                        {{ $shift['notes_worker'] }}
                    </p>
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-12">
            <div class="flex flex-col items-center space-y-4">
                <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="space-y-2">
                    <h3 class="text-lg font-semibold text-white">No Shift Notes</h3>
                    <p class="text-gray-400 text-sm max-w-sm">
                        No notes have been added to this shift yet.
                    </p>
                </div>
            </div>
        </div>
    @endif
@else
    <div class="text-center py-12">
        <div class="flex flex-col items-center space-y-4">
            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-white">No Shift Data</h3>
                <p class="text-gray-400 text-sm max-w-sm">
                    Unable to load shift details. Please try refreshing the page.
                </p>
            </div>
        </div>
    </div>
@endif 