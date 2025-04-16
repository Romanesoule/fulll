<?php

declare(strict_types=1);

namespace Fulll\Domain\Fleet;

interface FleetRepositoryInterface
{
    public function getById(string $fleetId): ?Fleet;

    public function create(Fleet $fleet): void;

    public function getAll(): array;

    public function exists(string $fleetId): bool;
}
