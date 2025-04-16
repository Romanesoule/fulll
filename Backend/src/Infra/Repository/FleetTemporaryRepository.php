<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;


use Fulll\Domain\Fleet\Fleet;
use Fulll\Domain\Fleet\FleetRepositoryInterface;
use Exception;

class FleetTemporaryRepository implements FleetRepositoryInterface
{

    private array $fleets = [];

    /**
     * @throws Exception
     */
    public function getById(string $fleetId): ?Fleet
    {
        if (!$this->exists($fleetId)) {
            throw new Exception("this fleet $fleetId is not registered");
        }
        return $this->fleets[$fleetId];
    }

    /**
     * @throws Exception
     */
    public function create(Fleet $fleet): void
    {
        $fleetId =$fleet->getId();
        if ($this->exists($fleetId)) {
            throw new Exception("this fleet $fleetId is already registered");
        }
        $this->fleets[$fleetId] = $fleet;
    }

    public function exists(string $fleetId): bool
    {
        return isset($this->fleets[$fleetId]);
    }

    public function getAll(): array
    {
        return $this->fleets;
    }
}
