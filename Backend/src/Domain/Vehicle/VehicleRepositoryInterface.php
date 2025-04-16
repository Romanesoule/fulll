<?php

declare(strict_types=1);

namespace Fulll\Domain\Vehicle;

interface VehicleRepositoryInterface
{
    public function existsInFleet(string $plateNumber, string $fleetId): bool;

    public function getByPlateAndFleet(string $plateNumber, string $fleetId): ?Vehicle;

    public function save(Vehicle $vehicle, string $fleetId): void;
}
