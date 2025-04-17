<?php

declare(strict_types=1);

namespace Fulll\Domain\Vehicle;

use Fulll\Domain\Location\Location;
use Fulll\Domain\Exceptions\VehicleAlreadyParkedException;

class Vehicle
{
    private string $plateNumber;
    private ?Location $location = null;
    private ?int $id = null;

    public function __construct(string $plateNumber)
    {
        $this->plateNumber = $plateNumber;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @throws VehicleAlreadyParkedException
     */
    public function park(Location $location, ?Location $lastLocation): void
    {

        if ($lastLocation && $location->isEquals($lastLocation)) {
            throw new VehicleAlreadyParkedException('this vehicle is already parked at this location');
        }

        $this->setLocation($location);
    }

    public function isParked(): bool
    {
        return $this->location !== null;
    }
}