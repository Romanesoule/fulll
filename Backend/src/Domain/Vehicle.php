<?php

declare(strict_types=1);

namespace Fulll\Domain;

use Exception;

class Vehicle
{
    private string $plateNumber;
    private ?Location $location = null;

    public function __construct(string $plateNumber)
    {
        $this->plateNumber = $plateNumber;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @throws Exception
     */
    public function park(Location $location): void
    {

        if ($this->isParked() && $this->location->getCoordinates() === $location->getCoordinates()) {
            throw new Exception('this vehicle is already parked at this location');
        }

        $this->setLocation($location);
    }

    public function isParked(): bool
    {
        return $this->location !== null;
    }
}