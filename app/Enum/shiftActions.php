<?php

namespace App\Enum;

enum shiftActions: string
{
    case PUNCH = 'punch';
    case BAILOUT = 'bailout';
    case REQUEST_SHIFT = 'requestShift';
    case ACCEPT_SHIFT = 'acceptShift';
    case DECLINE_SHIFT = 'declineShift';

    public function label(): string
    {
        return match($this) {
            self::PUNCH => 'Punch',
            self::BAILOUT => 'Bailout',
            self::REQUEST_SHIFT => 'Request Shift',
            self::ACCEPT_SHIFT => 'Accept Shift',
            self::DECLINE_SHIFT => 'Decline Shift',
        };
    }
    
}
