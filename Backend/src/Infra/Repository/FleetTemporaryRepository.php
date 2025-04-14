<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Exception;
use Fulll\Domain\Fleet;
use Fulll\Domain\Repository\FleetRepositoryInterface;

class FleetTemporaryRepository implements FleetRepositoryInterface
{

    private array $fleets = [];

    /**
     * @throws Exception
     */
    public function getFleet(string $fleetId): ?Fleet
    {
        if (!$this->isFleetAlreadyRegistered($fleetId)) {
            throw new Exception("this fleet $fleetId is not registered");
        }
        return $this->fleets[$fleetId];
    }

    /**
     * @throws Exception
     */
    public function createFleet(Fleet $fleet): void
    {
        $fleetId =$fleet->getId();
        if ($this->isFleetAlreadyRegistered($fleetId)) {
            throw new Exception("this fleet $fleetId is already registered");
        }
        $this->fleets[$fleetId] = $fleet;
    }

    public function isFleetAlreadyRegistered(string $fleetId): bool
    {
        return isset($this->fleets[$fleetId]);
    }
}
