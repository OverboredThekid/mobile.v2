<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class CalendarData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_key',
        'data_type', // 'userShifts', 'availability', 'timeOff'
        'data',
        'meta_etag',
        'meta_last_updated',
        'fetched_at',
        'is_stale',
    ];

    protected $casts = [
        'data' => 'array',
        'fetched_at' => 'datetime',
        'is_stale' => 'boolean',
    ];

    /**
     * Get calendar data for a specific date range
     */
    public static function getCalendarData(string $userId, string $from, string $to): array
    {
        $calendarData = [];
        
        // Get all dates in range
        $startDate = Carbon::parse($from);
        $endDate = Carbon::parse($to);
        
        while ($startDate->lte($endDate)) {
            $dateKey = $startDate->format('Y-m-d');
            
            // Get data for this date
            $dateData = self::getDateData($userId, $dateKey);
            
            if ($dateData) {
                $calendarData[$dateKey] = $dateData;
            } else {
                // Return empty structure if no data
                $calendarData[$dateKey] = [
                    'userShifts' => [],
                    'availability' => [],
                    'timeOff' => []
                ];
            }
            
            $startDate->addDay();
        }
        
        return $calendarData;
    }

    /**
     * Get data for a specific date
     */
    public static function getDateData(string $userId, string $dateKey): ?array
    {
        $records = self::where('user_id', $userId)
            ->where('date_key', $dateKey)
            ->get()
            ->groupBy('data_type');

        if ($records->isEmpty()) {
            return null;
        }

        return [
            'userShifts' => $records->get('userShifts', collect())->first()?->data ?? [],
            'availability' => $records->get('availability', collect())->first()?->data ?? [],
            'timeOff' => $records->get('timeOff', collect())->first()?->data ?? [],
        ];
    }

    /**
     * Store calendar data
     */
    public static function storeCalendarData(string $userId, array $calendarData, array $metaData = []): void
    {
        foreach ($calendarData as $dateKey => $dateData) {
            // Store user shifts
            if (!empty($dateData['userShifts'])) {
                self::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'date_key' => $dateKey,
                        'data_type' => 'userShifts'
                    ],
                    [
                        'data' => $dateData['userShifts'],
                        'meta_etag' => $metaData['etag'] ?? null,
                        'meta_last_updated' => $metaData['last_updated'] ?? null,
                        'fetched_at' => now(),
                        'is_stale' => false,
                    ]
                );
            }

            // Store availability
            if (!empty($dateData['availability'])) {
                self::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'date_key' => $dateKey,
                        'data_type' => 'availability'
                    ],
                    [
                        'data' => $dateData['availability'],
                        'meta_etag' => $metaData['etag'] ?? null,
                        'meta_last_updated' => $metaData['last_updated'] ?? null,
                        'fetched_at' => now(),
                        'is_stale' => false,
                    ]
                );
            }

            // Store time off
            if (!empty($dateData['timeOff'])) {
                self::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'date_key' => $dateKey,
                        'data_type' => 'timeOff'
                    ],
                    [
                        'data' => $dateData['timeOff'],
                        'meta_etag' => $metaData['etag'] ?? null,
                        'meta_last_updated' => $metaData['last_updated'] ?? null,
                        'fetched_at' => now(),
                        'is_stale' => false,
                    ]
                );
            }
        }
    }

    /**
     * Check if data is stale based on meta information
     */
    public static function isDataStale(string $userId, array $metaData): bool
    {
        // Get the most recent record for this user
        $latestRecord = self::where('user_id', $userId)
            ->orderBy('fetched_at', 'desc')
            ->first();

        if (!$latestRecord) {
            return true; // No data exists, consider it stale
        }

        // Check if meta ETag has changed
        if (isset($metaData['etag']) && $latestRecord->meta_etag !== $metaData['etag']) {
            return true;
        }

        // Check if meta last_updated has changed
        if (isset($metaData['last_updated'])) {
            $metaLastUpdated = Carbon::parse($metaData['last_updated']);
            $recordLastUpdated = $latestRecord->meta_last_updated ? Carbon::parse($latestRecord->meta_last_updated) : null;
            
            if (!$recordLastUpdated || $metaLastUpdated->gt($recordLastUpdated)) {
                return true;
            }
        }

        // Check if data is older than 15 minutes
        if ($latestRecord->fetched_at->diffInMinutes(now()) > 15) {
            return true;
        }

        return false;
    }

    /**
     * Mark data as stale
     */
    public static function markAsStale(string $userId): void
    {
        self::where('user_id', $userId)->update(['is_stale' => true]);
    }

    /**
     * Clean up old data
     */
    public static function cleanupOldData(int $daysOld = 30): void
    {
        $cutoffDate = now()->subDays($daysOld);
        self::where('fetched_at', '<', $cutoffDate)->delete();
    }
} 