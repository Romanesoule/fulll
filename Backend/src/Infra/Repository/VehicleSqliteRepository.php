<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Fulll\Domain\Vehicle\Vehicle;
use Fulll\Domain\Vehicle\VehicleRepositoryInterface;
use PDO;

class VehicleSqliteRepository implements VehicleRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function existsInFleet(string $plateNumber, string $fleetId): bool
    {
        $statement = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM vehicles
            WHERE plate_number = :plate AND fleet_id = :fleet
        ");

        $statement->execute([
            'plate' => $plateNumber,
            'fleet' => $fleetId,
        ]);

        return (bool) $statement->fetchColumn();
    }

    public function getByPlateAndFleet(string $plateNumber, string $fleetId): ?Vehicle
    {
        $statement = $this->pdo->prepare("
            SELECT id, plate_number
            FROM vehicles
            WHERE plate_number = :plate AND fleet_id = :fleet
            LIMIT 1
        ");

        $statement->execute([
            'plate' => $plateNumber,
            'fleet' => $fleetId,
        ]);

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $vehicle = new Vehicle($row['plate_number']);
        $vehicle->setId((int)$row['id']);

        return $vehicle;
    }

    public function save(Vehicle $vehicle, string $fleetId): void
    {
        $statement = $this->pdo->prepare("
            INSERT OR IGNORE INTO vehicles (plate_number, fleet_id)
            VALUES (:plate, :fleet)
        ");

        $statement->execute([
            'plate' => $vehicle->getPlateNumber(),
            'fleet' => $fleetId,
        ]);
    }
}
