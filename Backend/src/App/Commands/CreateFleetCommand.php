<?php

declare(strict_types=1);

namespace Fulll\Application\Command;

use Fulll\Domain\Fleet;
use Fulll\Infra\FleetRepositoryInterface;

class CreateFleetCommand
{
    private FleetRepositoryInterface $fleetRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    public function execute(string $userId): string
    {
        $fleet = new Fleet($userId);
        $this->fleetRepository->createFleet($fleet);
        return $fleet->getId();
    }
}
