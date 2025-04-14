<?php

declare(strict_types=1);

namespace Fulll\Application\Command;

use Fulll\Infra\FleetRepositoryInterface;
use Fulll\Domain\Location;
use Exception;

class ParkVehicleCommand
{
    private FleetRepositoryInterface $fleetRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $fleetId, string $plateNumber, float $lat, float $lng, ?float $alt = null): void
    {
        $fleet = $this->fleetRepository->getFleet($fleetId);
        $vehicle = $fleet->getVehicle($plateNumber);
        $location = new Location($lat, $lng, $alt);
        $vehicle->park($location);
    }
}
