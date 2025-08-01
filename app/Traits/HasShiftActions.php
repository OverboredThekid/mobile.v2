<?php

namespace App\Traits;

use App\Enum\shiftActions;
use App\Http\Controllers\Actions\BailoutAction;
use App\Http\Controllers\Actions\PunchAction;
use App\Http\Controllers\Actions\RequestShiftAction;
use App\Http\Controllers\Actions\AcceptShiftAction;
use App\Http\Controllers\Actions\DeclineShiftAction;
use Filament\Actions\Action;

trait HasShiftActions
{
    /**
     * Get action by name with dynamic record support
     */
    public function getShiftAction(string $actionName, $record = null): Action
    {
        $methodName = $actionName . 'Action';
        
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
    public function getActionByEnum(shiftActions $action, $record = null): Action
    {
        return $this->getShiftAction($action->value, $record);
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
     * Magic method to handle dynamic action calls
     */
    public function __call($method, $arguments)
    {
        // Handle action calls like getPunchAction($record)
        if (str_starts_with($method, 'get') && str_ends_with($method, 'Action')) {
            $actionName = strtolower(str_replace(['get', 'Action'], '', $method));
            $record = $arguments[0] ?? null;
            return $this->getShiftAction($actionName, $record);
        }

        // Handle enum-based calls like getActionByEnum(shiftActions::PUNCH, $record)
        if ($method === 'getActionByEnum') {
            $action = $arguments[0] ?? null;
            $record = $arguments[1] ?? null;
            return $this->getActionByEnum($action, $record);
        }

        throw new \BadMethodCallException("Method {$method} not found");
    }
}
