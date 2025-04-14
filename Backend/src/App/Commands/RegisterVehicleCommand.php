<?php

declare(strict_types=1);

namespace Fulll\Application\Command;

use Exception;
use Fulll\Domain\Repository\FleetRepositoryInterface;

class RegisterVehicleCommand
{
    private FleetRepositoryInterface $fleetRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $fleetId, string $plateNumber): void
    {
        $fleet = $this->fleetRepository->getFleet($fleetId);
        $fleet->registerVehicle($plateNumber);
    }
}
