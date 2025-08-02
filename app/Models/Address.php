<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'api_id',
        'addressable_type',
        'addressable_id',
        'full_address',
        'street',
        'city',
        'state',
        'zip_code',
        'country',
        'comment',
        'lat',
        'lng',
        'address',
        'etag',
        'fetched_at',
    ];

    protected $casts = [
        'address' => 'array',
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'fetched_at' => 'datetime',
    ];

    /**
     * Get the parent addressable model.
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     * Get the latitude and longitude as an array
     */
    public function getCoordinates(): array
    {
        return [
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }

    /**
     * Check if the address has valid coordinates
     */
    public function hasValidCoordinates(): bool
    {
        return !is_null($this->lat) && !is_null($this->lng);
    }

    /**
     * Get the formatted address
     */
    public function getFormattedAddress(): string
    {
        return $this->full_address ?: $this->buildAddressString();
    }

    /**
     * Build address string from components
     */
    private function buildAddressString(): string
    {
        $parts = array_filter([
            $this->street,
            $this->city,
            $this->state,
            $this->zip_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }
} 