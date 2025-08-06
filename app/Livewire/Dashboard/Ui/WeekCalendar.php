<?php

namespace App\Livewire\Dashboard\Ui;

use App\Http\Controllers\API\CalendarApi;
use App\Traits\HasShiftActions;
use App\Traits\HasVenueModal;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Lazy;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Carbon\Carbon;

#[Lazy]
class WeekCalendar extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use HasShiftActions;
    use HasVenueModal;

    public $currentDate;
    public $selectedDate;
    public $calendarData = [];
    public $metaData = [];
    public $loading = true;
    public $error = null;
    public $isLazyLoading = true;

    // Calendar configuration
    public $weekStart = 0; // Sunday = 0, Monday = 1
    public $showEventIndicators = true;
    public $showTimeOffBars = true;
    public $showAvailabilityBars = true;

    // Event indicator colors
    public $eventColors = [
        'shift' => 'bg-green-500',
        'shift_request' => 'bg-yellow-500',
        'available' => 'bg-blue-500',
        'time_off' => 'bg-red-500',
        'availability' => 'bg-gray-400',
    ];

    public function mount()
    {
        // Set initial dates
        $this->currentDate = Carbon::now();
        $this->selectedDate = Carbon::now();
        
        // Load calendar data
        $this->loadCalendarData();
    }

    public function loadCalendarData()
    {
        $this->loading = true;
        $this->error = null;

        try {
            $calendarApi = new CalendarApi();
            
            // Get the week range
            $weekStart = $this->getWeekStart();
            $weekEnd = $this->getWeekEnd();
            
            // Load calendar data
            $this->calendarData = $calendarApi->getCalendarData(
                $weekStart->format('Y-m-d'),
                $weekEnd->format('Y-m-d')
            );

            // Load meta data
            $this->metaData = $calendarApi->getCalendarMeta();

            // Log the processed data for debugging
            Log::debug('WeekCalendar loaded data:', [
                'week_start' => $weekStart->format('Y-m-d'),
                'week_end' => $weekEnd->format('Y-m-d'),
                'calendar_data_keys' => array_keys($this->calendarData),
                'meta_data' => $this->metaData,
                'selected_date' => $this->selectedDate->format('Y-m-d'),
                'current_date' => $this->currentDate->format('Y-m-d')
            ]);

        } catch (\Exception $e) {
            Log::error('WeekCalendar::loadCalendarData error: ' . $e->getMessage());
            $this->error = 'Failed to load calendar data';
            $this->calendarData = [];
            $this->metaData = [];
        }

        $this->loading = false;
        $this->isLazyLoading = false;
    }

    public function goToPreviousWeek()
    {
        $this->currentDate = $this->currentDate->subWeek();
        $this->loadCalendarData();
        $this->dispatch('week-changed', [
            'currentDate' => $this->currentDate->format('Y-m-d'),
            'selectedDate' => $this->selectedDate->format('Y-m-d')
        ]);
    }

    public function goToNextWeek()
    {
        $this->currentDate = $this->currentDate->addWeek();
        $this->loadCalendarData();
        $this->dispatch('week-changed', [
            'currentDate' => $this->currentDate->format('Y-m-d'),
            'selectedDate' => $this->selectedDate->format('Y-m-d')
        ]);
    }

    public function goToToday()
    {
        $this->currentDate = Carbon::now();
        $this->selectedDate = Carbon::now();
        $this->loadCalendarData();
        $this->dispatch('week-changed', [
            'currentDate' => $this->currentDate->format('Y-m-d'),
            'selectedDate' => $this->selectedDate->format('Y-m-d')
        ]);
    }

    public function selectDate($date)
    {
        $this->selectedDate = Carbon::parse($date);
        $this->dispatch('date-selected', [
            'selectedDate' => $this->selectedDate->format('Y-m-d')
        ]);
    }

    public function getWeekStart()
    {
        return $this->currentDate->copy()->startOfWeek($this->weekStart);
    }

    public function getWeekEnd()
    {
        return $this->currentDate->copy()->endOfWeek($this->weekStart);
    }

    public function getWeekDays()
    {
        $days = [];
        $start = $this->getWeekStart();
        
        for ($i = 0; $i < 7; $i++) {
            $days[] = $start->copy()->addDays($i);
        }
        
        return $days;
    }

    public function getSelectedDateEvents()
    {
        $dateKey = $this->selectedDate->format('Y-m-d');
        return $this->calendarData[$dateKey] ?? [
            'userShifts' => [],
            'availability' => [],
            'timeOff' => []
        ];
    }

    public function getEventIndicators($date)
    {
        $dateKey = $date->format('Y-m-d');
        $dateData = $this->calendarData[$dateKey] ?? null;

        if (!$dateData) {
            return null;
        }

        $indicators = [];

        // Process user shifts - separate into myShifts and shiftRequests
        if (!empty($dateData['userShifts'])) {
            foreach ($dateData['userShifts'] as $shift) {
                $hasPendingRequest = isset($shift['shiftRequest']) && 
                                   $shift['shiftRequest']['status'] === 'pending';
                
                $indicators[] = [
                    'type' => $hasPendingRequest ? 'shift_request' : 'shift',
                    'color' => $hasPendingRequest ? $this->eventColors['shift_request'] : $this->eventColors['shift']
                ];
            }
        }

        // Process availability
        if (!empty($dateData['availability'])) {
            $indicators[] = [
                'type' => 'availability',
                'color' => $this->eventColors['availability']
            ];
        }

        // Process time off
        if (!empty($dateData['timeOff'])) {
            $indicators[] = [
                'type' => 'time_off',
                'color' => $this->eventColors['time_off']
            ];
        }

        // Debug logging
        if (!empty($indicators)) {
            Log::debug("Event indicators for {$dateKey}:", [
                'indicators' => $indicators,
                'userShifts' => count($dateData['userShifts'] ?? []),
                'availability' => count($dateData['availability'] ?? []),
                'timeOff' => count($dateData['timeOff'] ?? [])
            ]);
        }

        return $indicators;
    }

    public function getEventBars($date)
    {
        $dateKey = $date->format('Y-m-d');
        $dateData = $this->calendarData[$dateKey] ?? null;

        if (!$dateData) {
            return null;
        }

        $bars = [];

        // Time Off Bar - Red
        if (!empty($dateData['timeOff'])) {
            $bars[] = [
                'type' => 'time_off',
                'color' => 'bg-red-500'
            ];
        }

        // Availability Bar - Gray
        if (!empty($dateData['availability'])) {
            $bars[] = [
                'type' => 'availability',
                'color' => 'bg-gray-400'
            ];
        }

        // Debug logging
        if (!empty($bars)) {
            Log::debug("Event bars for {$dateKey}:", [
                'bars' => $bars,
                'timeOff' => count($dateData['timeOff'] ?? []),
                'availability' => count($dateData['availability'] ?? [])
            ]);
        }

        return $bars;
    }

    public function formatTimeRange($startTime, $endTime)
    {
        if (!$startTime || !$endTime) {
            return '';
        }

        try {
            $start = Carbon::parse($startTime);
            $end = Carbon::parse($endTime);
            return $start->format('g:i A') . ' - ' . $end->format('g:i A');
        } catch (\Exception $e) {
            return '';
        }
    }

    public function getFormattedCurrentDate()
    {
        return $this->currentDate->format('F Y');
    }

    public function getFormattedSelectedDate()
    {
        return $this->selectedDate->format('l, F j');
    }

    public function isToday($date)
    {
        return $date->isToday();
    }

    public function isSelected($date)
    {
        return $this->selectedDate->format('Y-m-d') === $date->format('Y-m-d');
    }

    public function isCurrentWeek()
    {
        return $this->currentDate->isCurrentWeek();
    }

    public function render()
    {
        // Show skeleton during lazy loading
        if ($this->isLazyLoading) {
            return view('livewire.dashboard.ui.week-calendar-skeleton');
        }

        $weekDays = $this->getWeekDays();
        $selectedDateEvents = $this->getSelectedDateEvents();

        return view('livewire.dashboard.ui.week-calendar', [
            'weekDays' => $weekDays,
            'selectedDateEvents' => $selectedDateEvents,
            'isCurrentWeek' => $this->isCurrentWeek(),
        ]);
    }
} 