<?php

declare(strict_types=1);

namespace Fulll\Domain\Fleet;

use Fulll\Domain\Vehicle\Vehicle;
use Fulll\Domain\Exceptions\VehicleAlreadyRegisteredInFleet;
use Fulll\Domain\Exceptions\VehicleNotRegisteredInFleet;

class Fleet
{
    private string $id;
    private string $userId;

    /**
     * @var Vehicle[]
     */
    private array $vehicles = [];

    public function __construct(string $userId)
    {
        $this->id = "fleet_$userId";
        $this->userId = $userId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }


    /**
     * @throws VehicleAlreadyRegisteredInFleet
     */
    public function registerVehicle(string $plateNumber): void
    {
        if ($this->vehicleExists($plateNumber)) {
            throw new VehicleAlreadyRegisteredInFleet("Vehicle $plateNumber is already registered in this fleet.");
        }

        $this->vehicles[$plateNumber] = new Vehicle($plateNumber);
    }

    public function vehicleExists(string $plateNumber): bool
    {
        return isset($this->vehicles[$plateNumber]);
    }


    /**
     * @throws VehicleNotRegisteredInFleet
     */
    public function getVehicle(string $plateNumber): Vehicle
    {
        if ($this->vehicleExists($plateNumber)) {
            throw new VehicleNotRegisteredInFleet("Vehicle $plateNumber is not registered in this fleet.");
        }

        return $this->vehicles[$plateNumber];
    }
}