<?php

namespace App\Traits;

use App\Enum\shiftActions;
use App\Http\Controllers\Actions\BailoutAction;
use App\Http\Controllers\Actions\PunchAction;
use App\Http\Controllers\Actions\RequestShiftAction;
use App\Http\Controllers\Actions\AcceptShiftAction;
use App\Http\Controllers\Actions\AvailableShiftsListAction;
use App\Http\Controllers\Actions\DeclineShiftAction;
use App\Http\Controllers\Actions\ShiftDetailsAction;
use App\Http\Controllers\Actions\ShiftRequestListAction;
use App\Http\Controllers\Actions\VenueDetailsAction;
use Filament\Actions\Action;

trait HasShiftActions
{
    /**
     * Get action by name with dynamic record support
     */
    public function getShiftAction(string|Action $actionName, $record = null): Action
    {
        if ($actionName instanceof Action) {
            return $actionName;
        }

        $methodName = "{$actionName}Action";
        
        if (!method_exists($this, $methodName)) {
            throw new \BadMethodCallException("Action method {$methodName} not found");
        }
        
        $action = $this->$methodName();
        
        // Set the record if provided
        if ($record !== null) {
            $action->record($record);
        }
        
        return $action;
    }

    /**
     * Get action by enum value
     */
    public function getActionByEnum(string $action, $record = null): Action
    {
        return $this->getShiftAction($action, $record);
    }

    /**
     * Create Punch Action
     */
    public function punchAction(): Action
    {
        return PunchAction::make('punch');
    }

    /**
     * Create Bailout Action
     */
    public function bailoutAction(): Action
    {
        return BailoutAction::make('bailout');
    }

    /**
     * Create Accept Shift Action
     */
    public function acceptShiftAction(): Action
    {
        return AcceptShiftAction::make('acceptShift');
    }

    /**
     * Create Decline Shift Action
     */
    public function declineShiftAction(): Action
    {
        return DeclineShiftAction::make('declineShift');
    }

    /**
     * Create Request Shift Action
     */
    public function requestShiftAction(): Action
    {
        return RequestShiftAction::make('requestShift');
    }

    /**
     * Shift Details Action
     */
    public function shiftDetailsAction(): Action
    {
        return ShiftDetailsAction::make('shiftDetails');
    }

    /**
     * Venue Details Action
     */
    public function venueDetailsAction(): Action
    {
        return VenueDetailsAction::make('venueDetails');
    }

    /**
     * Shift Request List Modal
     */
    public function shiftRequestListAction(): Action
    {
        return ShiftRequestListAction::make('shiftRequestList');
    }

    /**
     * Available Shifts List Modal
     */
    public function availableShiftsListAction(): Action
    {
        return AvailableShiftsListAction::make('availableShiftsList');
    }
}
