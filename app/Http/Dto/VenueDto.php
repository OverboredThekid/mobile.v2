<?php

namespace App\Http\Dto;

use Illuminate\Support\Carbon;

class VenueDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $team_id,
        public readonly string $venue_name,
        public readonly string $venue_slug,
        public readonly array $venue_type,
        public readonly string | array | null $venue_color,
        public readonly ?string $venue_comment,
        public readonly string | array | null $color_value,
        public readonly int $schedules_count,
        public readonly string | array | null $address,
        public readonly ?string $latitude = null,
        public readonly ?string $longitude = null,
        public readonly ?Carbon $created_at,
        public readonly ?Carbon $updated_at,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        // Get team_id from data or from current user context
        $teamId = $data['team_id'] ?? null;
        if (!$teamId) {
            $authService = new \App\Services\AuthApiService();
            $user = $authService->getStoredUser();
            $teamId = $user['team_id'] ?? '';
        }

        // Decode JSON fields that might be stored as strings
        $jsonFields = ['venue_type', 'venue_color', 'address'];
        foreach ($jsonFields as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $decoded = json_decode($data[$field], true);
                $data[$field] = $decoded !== null ? $decoded : $data[$field];
            }
        }

        return new self(
            id: $data['id'] ?? '',
            team_id: $teamId,
            venue_name: $data['venue_name'] ?? 'Unknown Venue',
            venue_slug: $data['venue_slug'] ?? '',
            venue_type: $data['venue_type'] ?? [],
            venue_color: $data['venue_color'] ?? null,
            venue_comment: $data['venue_comment'] ?? null,
            color_value: $data['color_value'] ?? null,
            schedules_count: $data['schedules_count'] ?? 0,
            address: $data['address'] ?? null,
            latitude: $data['latitude'] ?? null,
            longitude: $data['longitude'] ?? null,
            created_at: isset($data['created_at']) ? Carbon::parse($data['created_at']) : null,
            updated_at: isset($data['updated_at']) ? Carbon::parse($data['updated_at']) : null,
        );
    }

    public static function fromArray(array $data): self
    {
        // Handle both API response format and database format
        $venueData = [
            'id' => $data['id'] ?? $data['api_id'] ?? '',
            'team_id' => $data['team_id'] ?? '',
            'venue_name' => $data['venue_name'] ?? 'Unknown Venue',
            'venue_slug' => $data['venue_slug'] ?? '',
            'venue_type' => $data['venue_type'] ?? [],
            'venue_color' => $data['venue_color'] ?? null,
            'venue_comment' => $data['venue_comment'] ?? null,
            'color_value' => $data['color_value'] ?? null,
            'schedules_count' => $data['schedules_count'] ?? 0,
            'address' => $data['address'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'created_at' => $data['created_at'] ?? null,
            'updated_at' => $data['updated_at'] ?? null,
        ];

        // Decode JSON fields that might be stored as strings
        $jsonFields = ['venue_type', 'venue_color', 'address'];
        foreach ($jsonFields as $field) {
            if (isset($venueData[$field]) && is_string($venueData[$field])) {
                $decoded = json_decode($venueData[$field], true);
                $venueData[$field] = $decoded !== null ? $decoded : $venueData[$field];
            }
        }

        return self::fromApiResponse($venueData);
    }

    public function hasValidLocation(): bool
    {
        // First check if coordinates are at the root level
        if (isset($this->venue_name)) {
            $lat = $this->latitude ?? null;
            $lng = $this->longitude ?? null;
            
            if (!empty($lat) && !empty($lng) && is_numeric($lat) && is_numeric($lng)) {
                return true;
            }
        }

        // Then check if coordinates are in address object
        if (!$this->address) {
            return false;
        }

        // Handle both array and object formats
        if (is_array($this->address)) {
            // Check for both lat/lng and latitude/longitude naming conventions
            $lat = $this->address['lat'] ?? $this->address['latitude'] ?? null;
            $lng = $this->address['lng'] ?? $this->address['longitude'] ?? null;
        } else {
            return false;
        }

        return !empty($lat) && !empty($lng) && is_numeric($lat) && is_numeric($lng);
    }

    public function getCoordinates(): array
    {
        // First check if coordinates are at the root level
        if (isset($this->venue_name)) {
            $lat = $this->latitude ?? null;
            $lng = $this->longitude ?? null;
            
            if (!empty($lat) && !empty($lng) && is_numeric($lat) && is_numeric($lng)) {
                $lat = (float)$lat;
                $lng = (float)$lng;
                
                // Debug logging
                \Illuminate\Support\Facades\Log::info('VenueDto::getCoordinates (root level)', [
                    'venue_id' => $this->id,
                    'venue_name' => $this->venue_name,
                    'latitude' => $lat,
                    'longitude' => $lng
                ]);
                
                return [$lat, $lng];
            }
        }

        // Then check if coordinates are in address object
        if ($this->hasValidLocation()) {
            if (is_array($this->address)) {
                // Check for both lat/lng and latitude/longitude naming conventions
                $lat = (float)($this->address['lat'] ?? $this->address['latitude'] ?? 0);
                $lng = (float)($this->address['lng'] ?? $this->address['longitude'] ?? 0);
                
                // Debug logging
                \Illuminate\Support\Facades\Log::info('VenueDto::getCoordinates (address object)', [
                    'venue_id' => $this->id,
                    'venue_name' => $this->venue_name,
                    'address' => $this->address,
                    'lat' => $lat,
                    'lng' => $lng,
                    'hasValidLocation' => $this->hasValidLocation()
                ]);
                
                return [$lat, $lng];
            }
        }
        // Default to San Francisco if no coordinates
        return [37.7749, -122.4194];
    }

    public function getAddressString(): string
    {
        if (!$this->address || !is_array($this->address)) {
            return '';
        }

        // Try to get full_address first
        if (!empty($this->address['full_address'])) {
            return $this->address['full_address'];
        }

        // Build address from components
        $parts = array_filter([
            $this->address['street'] ?? null,
            $this->address['city'] ?? null,
            $this->address['state'] ?? null,
            $this->address['zip_code'] ?? null,
            $this->address['country'] ?? null,
        ]);

        return implode(', ', $parts);
    }

    public function getDisplayName(): string
    {
        return $this->venue_name ?: 'Unknown Venue';
    }

    public function getColorValue(): string
    {
        return $this->color_value ?: $this->venue_color['value'] ?? '';
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

    public function hasType(string $type): bool
    {
        return in_array($type, $this->venue_type);
    }

    public function getPrimaryType(): ?string
    {
        return $this->venue_type[0] ?? null;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'team_id' => $this->team_id,
            'venue_name' => $this->venue_name,
            'venue_slug' => $this->venue_slug,
            'venue_type' => $this->venue_type,
            'venue_color' => $this->venue_color,
            'venue_comment' => $this->venue_comment,
            'color_value' => $this->color_value,
            'schedules_count' => $this->schedules_count,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'hasValidLocation' => $this->hasValidLocation(),
            'coordinates' => $this->getCoordinates(),
            'displayName' => $this->getDisplayName(),
            'colorClass' => $this->getColorClass(),
            'primaryType' => $this->getPrimaryType(),
            'addressString' => $this->getAddressString(),
        ];
    }
} 