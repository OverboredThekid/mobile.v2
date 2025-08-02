<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'api_id',
        'team_id',
        'venue_name',
        'venue_slug',
        'venue_type',
        'venue_color',
        'venue_comment',
        'color_value',
        'schedules_count',
        'etag',
        'fetched_at',
    ];

    protected $casts = [
        'venue_type' => 'array',
        'venue_color' => 'array',
        'fetched_at' => 'datetime',
    ];

    /**
     * Get the venue's address.
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Get the venue's display name
     */
    public function getDisplayName(): string
    {
        return $this->venue_name;
    }

    /**
     * Get the venue's color value
     */
    public function getColorValue(): string
    {
        return $this->color_value ?: $this->venue_color['value'] ?? '';
    }

    /**
     * Check if venue has a specific type
     */
    public function hasType(string $type): bool
    {
        return in_array($type, $this->venue_type ?? []);
    }

    /**
     * Get the venue's primary type
     */
    public function getPrimaryType(): ?string
    {
        return $this->venue_type[0] ?? null;
    }

    /**
     * Check if venue has valid coordinates
     */
    public function hasValidCoordinates(): bool
    {
        return $this->address && $this->address->hasValidCoordinates();
    }

    /**
     * Get venue coordinates as array
     */
    public function getCoordinates(): array
    {
        if ($this->hasValidCoordinates()) {
            return [$this->address->lat, $this->address->lng];
        }
        // Default to San Francisco if no coordinates
        return [37.7749, -122.4194];
    }

    /**
     * Get formatted address string
     */
    public function getAddressString(): string
    {
        if ($this->address) {
            return $this->address->getFormattedAddress();
        }
        return '';
    }

    /**
     * Convert venue to array with address data
     */
    public function toArrayWithAddress(): array
    {
        $data = $this->toArray();
        
        if ($this->address) {
            $data['address'] = [
                'full_address' => $this->address->full_address,
                'street' => $this->address->street,
                'city' => $this->address->city,
                'state' => $this->address->state,
                'zip_code' => $this->address->zip_code,
                'country' => $this->address->country,
                'lat' => $this->address->lat,
                'lng' => $this->address->lng,
                'comment' => $this->address->comment,
            ];
        } else {
            $data['address'] = null;
        }

        return $data;
    }
}
