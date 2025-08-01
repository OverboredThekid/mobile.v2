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
@elseif($shift && isset($shift['documents']) && is_array($shift['documents']))
    <div class="space-y-4">
        @foreach($shift['documents'] as $document)
            <div class="bg-gray-800 rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-white font-medium">{{ $document['name'] ?? 'Unknown Document' }}</span>
                    <span class="text-gray-400 text-sm">{{ $document['type'] ?? 'Unknown Type' }}</span>
                </div>
                
                @if(isset($document['description']))
                    <p class="text-gray-400 text-sm">{{ $document['description'] }}</p>
                @endif
                
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Size</span>
                    <span class="text-white">{{ $document['size'] ?? 'Unknown' }}</span>
                </div>
                
                @if(isset($document['uploaded_at']))
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Uploaded</span>
                        <span class="text-white">{{ $document['uploaded_at'] }}</span>
                    </div>
                @endif
                
                @if(isset($document['url']))
                    <div class="pt-2">
                        <a href="{{ $document['url'] }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 text-accent hover:text-accent-focus text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            View Document
                        </a>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z" />
                </svg>
            </div>
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-white">No Documents</h3>
                <p class="text-gray-400 text-sm max-w-sm">
                    No documents are available for this shift at the moment.
                </p>
            </div>
        </div>
    </div>
@endif 