@if($loading)
    <div class="animate-pulse space-y-4">
        <div class="h-6 bg-gray-800 rounded"></div>
        <div class="space-y-3">
            <div class="bg-gray-800 rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="h-4 bg-gray-700 rounded w-32"></div>
                    <div class="h-4 bg-gray-700 rounded w-20"></div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between bg-gray-700 rounded p-2">
                        <div class="h-4 bg-gray-600 rounded w-24"></div>
                        <div class="h-3 bg-gray-600 rounded w-16"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif($shift && isset($shift['timePunches']) && is_array($shift['timePunches']))
    <div class="space-y-4">
        @foreach($shift['timePunches'] as $punch)
            <div class="bg-gray-800 rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-white font-medium">{{ $punch['worker_name'] ?? 'Unknown Worker' }}</span>
                    <span class="text-gray-400 text-sm">{{ $punch['type'] ?? 'Unknown' }}</span>
                </div>
                
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Time</span>
                    <span class="text-white">{{ $punch['time'] ?? 'Unknown' }}</span>
                </div>
                
                @if(isset($punch['location']))
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Location</span>
                        <span class="text-white">{{ $punch['location'] }}</span>
                    </div>
                @endif
                
                @if(isset($punch['notes']))
                    <div class="text-sm">
                        <span class="text-gray-400">Notes:</span>
                        <p class="text-white mt-1">{{ $punch['notes'] }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-12">
        <div class="flex flex-col items-center space-y-4">
            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-white">No Time Punches</h3>
                <p class="text-gray-400 text-sm max-w-sm">
                    No time punches have been recorded for this shift yet.
                </p>
            </div>
        </div>
    </div>
@endif 