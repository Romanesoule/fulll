<?php

declare(strict_types=1);

namespace Fulll\Domain;
use Exception;

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
     * @throws Exception
     */
    public function registerVehicle(string $plateNumber): void
    {
        if ($this->isVehicleAlreadyRegistered($plateNumber)) {
            throw new Exception("this vehicle $plateNumber is already registered in this fleet");
        }

        $this->vehicles[$plateNumber] = new Vehicle($plateNumber);
    }

    private function isVehicleAlreadyRegistered(string $plateNumber): bool
    {
        return array_key_exists($plateNumber, $this->vehicles);
    }

    /**
     * @throws Exception
     */
    public function getVehicle($plateNumber): Vehicle
    {
        if (!$this->isVehicleAlreadyRegistered($plateNumber)) {
            throw new Exception("this vehicle $plateNumber doesn\'t exists in this fleet");
        }

        return $this->vehicles[$plateNumber];
    }
}