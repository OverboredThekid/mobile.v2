@php
    use App\Enum\shiftActions;
@endphp

<div
    x-data="{
        select(date) {
            $wire.selectDate(date);
        }
    }"
    class="bg-base-200 rounded-2xl overflow-hidden"
>

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <button class="btn btn-sm btn-ghost text-base-content/70 hover:text-base-content" wire:click="goToPreviousWeek" wire:loading.attr="disabled">
            <x-heroicon-o-chevron-left class="h-5 w-5" />
        </button>

        <div class="flex items-center gap-2">
            <h3 class="text-lg font-semibold text-base-content">{{ $this->getFormattedCurrentDate() }}</h3>
            @if(!$isCurrentWeek)
                <button class="btn btn-sm btn-ghost btn-circle text-base-content/70 hover:text-base-content" wire:click="goToToday" wire:loading.attr="disabled">
                    <x-heroicon-s-arrow-uturn-left class="h-4 w-4" />
                </button>
            @endif
        </div>

        <button class="btn btn-sm btn-ghost text-base-content/70 hover:text-base-content" wire:click="goToNextWeek" wire:loading.attr="disabled">
            <x-heroicon-o-chevron-right class="h-5 w-5" />
        </button>
    </div>

    <!-- Loading -->
    @if($loading || $error)
        <div class="grid grid-cols-7 gap-1 mb-6">
            @for($i = 0; $i < 7; $i++)
                <div class="text-center py-3 px-1 rounded-xl bg-base-100 animate-pulse">
                    <div class="h-3 bg-base-300 rounded mb-1"></div>
                    <div class="h-5 bg-base-300 rounded"></div>
                </div>
            @endfor
        </div>
        @if($error)
            <div class="text-center py-8 text-error">
                <x-heroicon-o-information-circle class="h-12 w-12 mx-auto mb-4" />
                <p>{{ $error }}</p>
                <button class="btn btn-sm btn-primary mt-4" wire:click="loadCalendarData">Try Again</button>
            </div>
        @endif
    @else
        <!-- Week Days -->
        <div class="grid grid-cols-7 gap-1 mb-6">
            @foreach($weekDays as $day)
                @php
                    $isToday = $this->isToday($day);
                    $isSelected = $this->isSelected($day);
                    $dayKey = $day->format('Y-m-d');
                    $eventIndicators = $this->getEventIndicators($day);
                    $eventBars = $this->getEventBars($day);
 
                    $backgroundClass = '';
                    $borderClass = '';
                    $textClass = 'text-base-content/80 hover:text-base-content';
 
                    $hasAvailability = collect($eventIndicators)->contains('type', 'availability');
                    $hasTimeOff = collect($eventIndicators)->contains('type', 'time_off');
                    $hasShifts = collect($eventIndicators)->contains('type', 'shift');
                    $hasShiftRequests = collect($eventIndicators)->contains('type', 'shift_request');
 
                    if ($isSelected) {
                        $backgroundClass = 'bg-primary text-primary-content';
                        $borderClass = 'border-2 border-accent shadow-md';
                        $textClass = 'text-primary-content';
                    } elseif ($hasTimeOff) {
                        $backgroundClass = 'bg-error/10';
                        $borderClass = 'border border-red-500/40';
                        $textClass = 'text-error';
                    } elseif ($hasAvailability) {
                        $backgroundClass = 'bg-info/10';
                        $borderClass = 'border border-blue-500/40';
                        $textClass = 'text-blue-600';
                    } elseif ($isToday) {
                        $backgroundClass = 'bg-accent/20';
                        $textClass = 'text-accent-content';
                    }
                @endphp
 
                <div
                    @click="select('{{ $dayKey }}')"
                    class="text-center py-3 px-1 rounded-xl cursor-pointer relative transition-all duration-200 {{ $backgroundClass }} {{ $borderClass }} {{ $textClass }}"
                >
                    <!-- Event bars at the top -->
                    @if($eventBars && count($eventBars) > 0)
                        <div class="absolute top-1 left-1 right-1 flex flex-col gap-0.5">
                            @foreach($eventBars as $bar)
                                <div class="h-0.5 {{ $bar['color'] }} rounded-full"></div>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="text-xs font-medium mb-1">{{ $day->format('D') }}</div>
                    <div class="font-bold text-lg">{{ $day->format('j') }}</div>
 
                    <!-- Event indicators (dots) at the bottom -->
                    @if($eventIndicators && count($eventIndicators) > 0)
                        <div class="flex gap-0.5 justify-center mt-1">
                            @foreach(array_slice($eventIndicators, 0, 3) as $indicator)
                                <div class="h-1.5 w-1.5 rounded-full {{ $indicator['color'] }}"></div>
                            @endforeach
                            @if(count($eventIndicators) > 3)
                                <div class="text-xs font-bold text-base-content/60">+{{ count($eventIndicators) - 3 }}</div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Selected Events -->
        <div class="bg-base-100 rounded-2xl">
            <h3 class="font-bold text-lg mb-4 text-base-content">
                {{ $this->getFormattedSelectedDate() }}
            </h3>

            @if(empty($selectedDateEvents['userShifts']) && empty($selectedDateEvents['timeOff']) && empty($selectedDateEvents['availability']))
                <div class="text-center py-12">
                    <x-heroicon-o-calendar class="h-12 w-12 mx-auto mb-3 text-base-content/30" />
                    <p class="text-base-content/50 text-sm">No events scheduled for this day</p>
                </div>
            @endif

            <div class="space-y-3">
                @foreach($selectedDateEvents['timeOff'] ?? [] as $timeOff)
                    <div class="bg-red-500/10 border border-red-500/20 text-red-600 p-3 rounded-xl">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">{{ $timeOff['title'] ?? 'Time Off' }}</span>
                            @if(isset($timeOff['start_time'], $timeOff['end_time']))
                                <span class="text-sm opacity-80">| {{ $this->formatTimeRange($timeOff['start_time'], $timeOff['end_time']) }}</span>
                            @endif
                        </div>
                        @if(isset($timeOff['reason']))
                            <div class="mt-2 pt-2 border-t border-red-500/20 text-sm">{{ $timeOff['reason'] }}</div>
                        @endif
                    </div>
                @endforeach

                @foreach($selectedDateEvents['availability'] ?? [] as $availability)
                    <div class="bg-blue-500/10 border border-blue-500/20 text-blue-600 p-3 rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold">{{ $availability['title'] ?? 'Availability' }}:</span>
                            <span class="text-sm">
                                @if(isset($availability['start_time'], $availability['end_time']))
                                    {{ $this->formatTimeRange($availability['start_time'], $availability['end_time']) }}
                                @elseif(isset($availability['start_date'], $availability['end_date']))
                                    {{ \Carbon\Carbon::parse($availability['start_date'])->format('M j') }} - {{ \Carbon\Carbon::parse($availability['end_date'])->format('M j') }}
                                @else
                                    All day
                                @endif
                            </span>
                        </div>
                        @if(isset($availability['notes']))
                            <div class="mt-1 text-sm opacity-80">{{ $availability['notes'] }}</div>
                        @endif
                    </div>
                @endforeach

                @foreach($selectedDateEvents['userShifts'] ?? [] as $shift)
                    @php
                        $shiftData = collect($shift);
                        $shiftRequest = collect($shiftData->get('shiftRequest', []));
                        $hasPendingRequest = $shiftRequest->get('status') === 'pending';
                        $shiftStatus = $shiftData->get('shift_type', 'unknown');
                        $actions = match (true) {
                            $hasPendingRequest => shiftActions::getShiftRequestActions(),
                            $shiftStatus === 'confirmed' => shiftActions::getMyShiftActions(),
                            default => shiftActions::getAvailableShiftActions(),
                        };
                    @endphp

                    <livewire:user.component.shift-card 
                        :shift="$shift" 
                        :actions="$actions"
                        :options="[
                            'showStatus' => true,
                            'showCallTime' => true,
                            'showVenue' => true,
                            'showRequestedBy' => $hasPendingRequest
                        ]"
                        :key="'shift-' . $shift['id']"
                    />
                @endforeach
            </div>
        </div>
    @endif
</div>

<x-filament-actions::modals />
