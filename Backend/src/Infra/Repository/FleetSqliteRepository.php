<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Fulll\Domain\Fleet\Fleet;
use Fulll\Domain\Fleet\FleetRepositoryInterface;
use PDO;

class FleetSqliteRepository implements FleetRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function initializeSchema(): void
    {
        $schemaFile = __DIR__ . '/../Database/schema.sql';

        if (!file_exists($schemaFile)) {
            throw new \RuntimeException("Schema SQL file not found: $schemaFile");
        }

        $sql = file_get_contents($schemaFile);
        $this->pdo->exec($sql);
    }

    public function getById(string $fleetId): ?Fleet
    {
        $stmt = $this->pdo->prepare('SELECT id, user_id FROM fleets WHERE id = :id');
        $stmt->execute(['id' => $fleetId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Fleet($row['user_id']);
    }

    public function create(Fleet $fleet): void
    {
        $stmt = $this->pdo->prepare('INSERT OR REPLACE INTO fleets (id, user_id) VALUES (:id, :user_id)');
        $stmt->execute([
            'id' => $fleet->getId(),
            'user_id' => $fleet->getUserId()
        ]);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT id FROM fleets');
        $fleetIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $fleets = [];
        foreach ($fleetIds as $fleetId) {
            $fleet = $this->getById($fleetId);
            if ($fleet !== null) {
                $fleets[] = $fleet;
            }
        }

        return $fleets;
    }

    public function exists(string $fleetId): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM fleets WHERE id = :id');
        $stmt->execute(['id' => $fleetId]);
        return (bool) $stmt->fetchColumn();
    }
}
