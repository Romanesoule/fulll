<?php

declare(strict_types=1);

namespace Fulll\Domain\Location;

class Location
{
    private float $latitude;
    private float $longitude;
    private ?float $altitude;

    public function __construct(float $latitude, float $longitude, ?float $altitude = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    public function getCoordinates(): array
    {
        return [$this->latitude, $this->longitude, $this->alt];
    }

    public function isEquals(Location $compared): bool
    {
        return (
            $this->getLatitude() === $compared->getLatitude() &&
            $this->getLongitude() === $compared->getLongitude() &&
            $this->getAltitude() === $compared->getAltitude()
        );
    }


}