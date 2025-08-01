<?php

namespace App\Http\Dto;

class VenueDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $venue_name,
        public readonly array $venue_type,
        public readonly ?string $venue_comment,
        public readonly ?string $address,
        public readonly ?string $latitude,
        public readonly ?string $longitude
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            venue_name: $data['venue_name'] ?? 'Unknown Venue',
            venue_type: $data['venue_type'] ?? ['hotel'],
            venue_comment: $data['venue_comment'] ?? null,
            address: $data['address'] ?? null,
            latitude: $data['latitude'] ?? null,
            longitude: $data['longitude'] ?? null
        );
    }

    public function hasValidLocation(): bool
    {
        return !empty($this->latitude) && !empty($this->longitude) &&
               is_numeric($this->latitude) && is_numeric($this->longitude);
    }

    public function getCoordinates(): array
    {
        if ($this->hasValidLocation()) {
            return [(float)$this->latitude, (float)$this->longitude];
        }
        // Default to San Francisco if no coordinates
        return [37.7749, -122.4194];
    }

    public function getDisplayName(): string
    {
        return $this->venue_name ?: 'Unknown Venue';
    }

    public function getColorClass(): string
    {
        if (empty($this->venue_type)) {
            return 'badge-neutral';
        }

        $primaryType = strtolower($this->venue_type[0]);
        
        return match($primaryType) {
            'hotel' => 'badge-primary',
            'restaurant' => 'badge-secondary',
            'event' => 'badge-accent',
            'corporate' => 'badge-info',
            'retail' => 'badge-success',
            'healthcare' => 'badge-warning',
            'education' => 'badge-error',
            default => 'badge-neutral'
        };
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'venue_name' => $this->venue_name,
            'venue_type' => $this->venue_type,
            'venue_comment' => $this->venue_comment,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'hasValidLocation' => $this->hasValidLocation(),
            'coordinates' => $this->getCoordinates(),
            'displayName' => $this->getDisplayName(),
            'colorClass' => $this->getColorClass()
        ];
    }
} 