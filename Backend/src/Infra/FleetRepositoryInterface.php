<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Fulll\Domain\Fleet;

interface FleetRepositoryInterface
{
    public function getFleet(string $fleetId): ?Fleet;

    public function createFleet(Fleet $fleet): void;

    public function isFleetAlreadyRegistered(string $fleetId): bool;
}
