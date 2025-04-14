<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Location
{
    private float $latitude;
    private float $longitude;
    private ?float $alt;

    public function __construct(float $latitude, float $longitude, ?float $alt = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->alt = $alt;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getAlt(): ?float
    {
        return $this->alt;
    }

    public function getCoordinates(): array
    {
        return [$this->latitude, $this->longitude, $this->alt];
    }
}