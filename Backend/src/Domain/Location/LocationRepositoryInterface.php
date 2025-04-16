<?php

declare(strict_types=1);

namespace Fulll\Domain\Location;

interface LocationRepositoryInterface
{
    public function save(Location $location): int;

    public function getById(int $id): ?Location;

    public function findByVehicleId(string $vehicleId): array;

    public function getLatestForVehicle(int $vehicleId): ?Location;
}
