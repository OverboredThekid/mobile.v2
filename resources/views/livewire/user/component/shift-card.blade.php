@php
    use App\Enum\shiftActions;
@endphp
<div class="card bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-700 hover:border-gray-600 transition-all duration-200">
    <div class="card-body p-6 pr-4">
        <!-- Header Section -->
        <div class="grid grid-cols-5 gap-6 mb-4">
            <!-- Title + Schedule Info (narrow) -->
            <div class="col-span-3">
                <h3 class="text-lg font-bold text-white mb-1">
                    {{ $shift['title'] }}
                </h3>

                @if($showRequestedBy && $this->getRequestedBy())
                    <p class="text-sm text-gray-400">
                        Requested by {{ $this->getRequestedBy() }}
                    </p>
                @endif

                @if($shift['schedule_title'])
                    <p class="text-sm text-gray-500">
                        {{ $shift['schedule_title'] }}
                    </p>
                @endif
            </div>

            <!-- Status + Details Button (right-aligned) -->
            <div class="col-span-2 flex items-start justify-end gap-2">
                @if($showStatus)
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $this->getStatusColor() }} text-white">
                        {{ $this->getStatusText() }}
                    </span>
                @endif
                <div class=" rounded-lg hover:bg-gray-700 transition-colors">
                     {{ ($this->getShiftAction(shiftActions::SHIFT_DETAILS->value))(['shift_id' => $shift['id'], 'Actions' => $actions]) }}
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-5 gap-6 items-start">
            <!-- Left Content -->
            <div class="col-span-3 space-y-2">
                <div>
                    <p class="text-white font-semibold mb-2">
                        {{ $this->getFormattedDate() }}
                    </p>
                    <p class="text-white text-lg mb-2">
                        {{ $this->getFormattedTime() }}
                    </p>
                    @if($showCallTime && $this->getFormattedCallTime())
                        <p class="text-gray-400 text-sm">
                            Call Time: {{ $this->getFormattedCallTime() }}
                        </p>
                    @endif
                </div>

                <div class="space-y-2">
                    @if($showVenue && $this->hasVenue())
                        <div class="flex items-center gap-2 text-gray-400">
                            {{ ($this->getShiftAction(shiftActions::VENUE_DETAILS->value))(['venue_id' => $this->getVenueId()]) }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Content: Actions -->
            @if(count($actions) > 0)
                <div class="col-span-1 flex flex-col gap-5 min-w-25 text-center" wire:ignore>
                    @foreach($actions as $actionKey)
                        {{ ($this->getShiftAction($actionKey))(['shift_id' => $shift['id']]) }}
                    @endforeach
                </div>
                <x-filament-actions::modals />
            @else
                <div class="col-span-1"></div>
            @endif
        </div>
    </div>
</div>
