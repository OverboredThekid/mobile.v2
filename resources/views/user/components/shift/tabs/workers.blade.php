@php
    // Helper functions
    function getWorkerInitials($name) {
        if (!$name) return 'W';
        $parts = explode(' ', $name);
        $initials = array_map(function($part) {
            return strtoupper(substr($part, 0, 1));
        }, $parts);
        return strtoupper(substr(implode('', $initials), 0, 2));
    }

    function getStatusBadgeClass($status) {
        $status = strtolower($status ?? 'confirmed');
        return match($status) {
            'confirmed' => 'badge-success',
            'pending' => 'badge-warning',
            'declined' => 'badge-error',
            default => 'badge-success'
        };
    }

    function formatTimeRange($startTime, $endTime) {
        if (!$startTime || !$endTime) return '';
        
        try {
            $start = \Carbon\Carbon::parse($startTime);
            $end = \Carbon\Carbon::parse($endTime);
            return $start->format('g:i A') . ' - ' . $end->format('g:i A');
        } catch (Exception $e) {
            return '';
        }
    }
@endphp

@if($loading)
    <div class="animate-pulse space-y-4">
        <div class="h-6 bg-gray-800 rounded"></div>
        <div class="space-y-3">
            <div class="bg-gray-800 rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="h-4 bg-gray-700 rounded w-24"></div>
                    <div class="h-4 bg-gray-700 rounded w-12"></div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between bg-gray-700 rounded p-2">
                        <div class="h-4 bg-gray-600 rounded w-32"></div>
                        <div class="h-3 bg-gray-600 rounded w-16"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif($shift && isset($shift['workers']) && is_array($shift['workers']))
    <div class="space-y-6" x-data="{ copiedPhone: null }">
        @foreach($shift['workers'] as $workerGroup)
            @php
                $shiftName = $workerGroup['role'] ?? 'Worker Group';
                $timeRange = formatTimeRange($workerGroup['start_time'] ?? null, $workerGroup['end_time'] ?? null);
                $workers = $workerGroup['workers'] ?? [];
                $filteredWorkers = array_filter($workers, function($worker) {
                    return isset($worker['name']) && trim($worker['name']) !== '';
                });
            @endphp

            <div class="space-y-0 rounded-2xl overflow-hidden shadow-sm border border-gray-700">
                <!-- Shift Header -->
                <div class="bg-gray-800 p-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">
                        {{ $shiftName }}
                    </h3>
                    @if($timeRange)
                        <p class="text-gray-400 font-medium">
                            {{ $timeRange }}
                        </p>
                    @endif
                </div>

                <!-- Workers Grid -->
                @if(count($filteredWorkers) > 0)
                    <div class="grid grid-cols-2 gap-0">
                        @foreach($filteredWorkers as $index => $worker)
                            <div class="bg-gray-700 p-6 flex flex-col items-center gap-3 border-gray-600 {{ $index % 2 === 0 ? 'border-r' : '' }} {{ $index < count($filteredWorkers) - 2 ? 'border-b' : '' }}">
                                <!-- Avatar -->
                                <div class="w-14 h-14 bg-gray-600 rounded-full flex items-center justify-center">
                                    <span class="text-lg font-bold text-white">
                                        {{ getWorkerInitials($worker['name']) }}
                                    </span>
                                </div>

                                <!-- Phone number -->
                                @if(isset($worker['phone_number']) || isset($worker['phone']))
                                    @php
                                        $phoneNumber = $worker['phone_number'] ?? $worker['phone'] ?? '';
                                    @endphp
                                    <button
                                        x-on:click="
                                            copiedPhone = '{{ $phoneNumber }}';
                                            navigator.clipboard.writeText('{{ $phoneNumber }}').then(() => {
                                                setTimeout(() => { copiedPhone = null; }, 2000);
                                            }).catch(() => {
                                                // Fallback for older browsers
                                                const textArea = document.createElement('textarea');
                                                textArea.value = '{{ $phoneNumber }}';
                                                document.body.appendChild(textArea);
                                                textArea.select();
                                                document.execCommand('copy');
                                                document.body.removeChild(textArea);
                                                setTimeout(() => { copiedPhone = null; }, 2000);
                                            });
                                        "
                                        class="relative group transition-all duration-200"
                                        :class="copiedPhone === '{{ $phoneNumber }}' ? 'scale-105' : 'hover:scale-105'"
                                    >
                                        <div class="flex items-center gap-2 px-3 py-2 rounded-xl transition-all duration-200"
                                             :class="copiedPhone === '{{ $phoneNumber }}' 
                                                ? 'bg-green-500/20 text-green-400 ring-2 ring-green-500/50' 
                                                : 'bg-gray-600/50 text-gray-300 hover:bg-gray-600 hover:text-white hover:shadow-md'">
                                            
                                            <svg x-show="copiedPhone !== '{{ $phoneNumber }}'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            
                                            <svg x-show="copiedPhone === '{{ $phoneNumber }}'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            
                                            <span class="text-sm font-mono font-medium">
                                                <span x-show="copiedPhone !== '{{ $phoneNumber }}'">{{ $phoneNumber }}</span>
                                                <span x-show="copiedPhone === '{{ $phoneNumber }}'">Copied!</span>
                                            </span>
                                        </div>
                                        
                                        <!-- Subtle copy hint -->
                                        <div x-show="copiedPhone !== '{{ $phoneNumber }}'" class="absolute -top-1 -right-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <div class="bg-gray-500/10 rounded-full p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </button>
                                @endif

                                <!-- Name -->
                                <h4 class="text-base font-semibold text-white text-center leading-tight">
                                    {{ $worker['name'] }}
                                </h4>

                                <!-- Status badge -->
                                <div class="badge badge-sm {{ getStatusBadgeClass($worker['status'] ?? 'confirmed') }}">
                                    {{ ucfirst($worker['status'] ?? 'confirmed') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-700 p-8 text-center">
                        <div class="text-4xl mb-2">👤</div>
                        <p class="text-gray-400">No workers assigned to this shift</p>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
            </div>
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-white">No Workers Assigned</h3>
                <p class="text-gray-400 text-sm max-w-sm">
                    No workers have been assigned to this shift yet.
                </p>
            </div>
        </div>
    </div>
@endif 