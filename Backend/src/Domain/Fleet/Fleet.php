<?php

declare(strict_types=1);

namespace Fulll\Domain\Fleet;

use Fulll\Domain\Vehicle\Vehicle;
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

    public function registerVehicle(string $plateNumber): void
    {
        $this->vehicles[$plateNumber] = new Vehicle($plateNumber);
    }

    /**
     * @throws Exception
     */
    public function getVehicle($plateNumber): Vehicle
    {
        if (!isset($this->vehicles[$plateNumber])) {
            throw new \Exception("Vehicle $plateNumber is not registered in this fleet.");
        }
        return $this->vehicles[$plateNumber];
    }
}