<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;


use Fulll\Domain\Location\Location;
use Fulll\Domain\Location\LocationRepositoryInterface;
use PDO;

class LocationSqliteRepository implements LocationRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Location $location): int
    {
        $query = "
            INSERT INTO locations (latitude, longitude, altitude, recorded_at)
            VALUES (:latitude, :longitude, :altitude, :recorded_at)
        ";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'latitude' => $location->getLatitude(),
            'longitude' => $location->getLongitude(),
            'altitude' => $location->getAltitude(),
            'recorded_at' => date('Y-m-d H:i:s')
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function getById(int $id): ?Location
    {
        $query = "
            SELECT id, latitude, longitude, altitude, recorded_at
            FROM locations
            WHERE id = :id
        ";

        $statement = $this->pdo->prepare($query);
        $statement->execute(['id' => $id]);

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Location(
            (float) $row['latitude'],
            (float) $row['longitude'],
            $row['altitude'] !== null ? (float) $row['altitude'] : null
        );
    }

    public function findByVehicleId(string $vehicleId): array
    {
        $query = "
            SELECT locations.id, locations.latitude, locations.longitude, locations.altitude, locations.recorded_at
            FROM locations
            INNER JOIN vehicle_locations ON vehicle_locations.location_id = locations.id
            WHERE vehicle_locations.vehicle_id = :vehicle_id
            ORDER BY locations.recorded_at DESC
        ";

        $statement = $this->pdo->prepare($query);
        $statement->execute(['vehicle_id' => $vehicleId]);

        $locations = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $locations[] = new Location(
                (float) $row['latitude'],
                (float) $row['longitude'],
                $row['altitude'] !== null ? (float) $row['altitude'] : null
            );
        }

        return $locations;
    }

    public function getLatestForVehicle(int $vehicleId): ?Location
    {
        $query = "
            SELECT locations.id, locations.latitude, locations.longitude, locations.altitude, locations.recorded_at
            FROM locations
            INNER JOIN vehicle_locations ON vehicle_locations.location_id = locations.id
            WHERE vehicle_locations.vehicle_id = :vehicle_id
            ORDER BY locations.recorded_at DESC
            LIMIT 1
        ";

        $statement = $this->pdo->prepare($query);
        $statement->execute(['vehicle_id' => $vehicleId]);

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Location(
            (float) $row['latitude'],
            (float) $row['longitude'],
            $row['altitude'] !== null ? (float) $row['altitude'] : null
        );
    }

    public function assignToVehicle(int $vehicleId, int $locationId): void
    {
        $statement = $this->pdo->prepare("
            INSERT INTO vehicle_locations (vehicle_id, location_id)
            VALUES (:vehicle_id, :location_id)
        ");

        $statement->execute([
            'vehicle_id' => $vehicleId,
            'location_id' => $locationId
        ]);
    }
}
