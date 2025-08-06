<?php

namespace App\Enum;

enum shiftActions: string
{
    case PUNCH = 'punch';
    case BAILOUT = 'bailout';
    case REQUEST_SHIFT = 'requestShift';
    case ACCEPT_SHIFT = 'acceptShift';
    case DECLINE_SHIFT = 'declineShift';
    case SHIFT_DETAILS = 'shiftDetails';
    case VENUE_DETAILS = 'venueDetails';

    public function label(): string
    {
        return match($this) {
            self::PUNCH => 'Punch',
            self::BAILOUT => 'Bailout',
            self::REQUEST_SHIFT => 'Request Shift',
            self::ACCEPT_SHIFT => 'Accept Shift',
            self::DECLINE_SHIFT => 'Decline Shift',
            self::SHIFT_DETAILS => 'Shift Details',
            self::VENUE_DETAILS => 'Venue Details',
        };
    }

    public static function getMyShiftActions(): array
    {
        return [
            self::PUNCH,
            self::BAILOUT,
        ];
    }

    public static function getShiftRequestActions(): array
    {
        return [
            self::ACCEPT_SHIFT,
            self::DECLINE_SHIFT,
        ];
    }

    public static function getAvailableShiftActions(): array
    {
        return [
            self::REQUEST_SHIFT,
        ];
    }
    
}
