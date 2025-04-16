<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Exception;
use Fulll\Domain\Fleet\FleetRepositoryInterface;
use Fulll\Domain\Location\Location;
use Fulll\Domain\Location\LocationRepositoryInterface;
use Fulll\Domain\Vehicle\VehicleRepositoryInterface;

class ParkVehicleCommand
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
        private LocationRepositoryInterface $locationRepository,
        private VehicleRepositoryInterface $vehicleRepository
    ) {}

    /**
     * @throws Exception
     */
    public function execute(string $fleetId, string $plateNumber, float $lat, float $lng, ?float $alt = null): void
    {
        if (!$this->fleetRepository->exists($fleetId)) {
            throw new Exception("this fleet $fleetId does not exists");
        }

        if (!$this->vehicleRepository->existsInFleet($plateNumber, $fleetId)) {
            throw new Exception("this vehicle $plateNumber does not exists in fleet $fleetId");
        }

        $vehicle = $this->vehicleRepository->getByPlateAndFleet($plateNumber, $fleetId);
        $vehicleId = $vehicle->getId();

        $location = new Location($lat, $lng, $alt);

        $lastLocation = $this->locationRepository->getLatestForVehicle($vehicleId);

        if ($lastLocation && $lastLocation->isEquals($location)) {
            throw new Exception("this vehicle $plateNumber is already parked at this localisation");
        }

        $vehicle->park($location);
        $locationId = $this->locationRepository->save($location);
        $this->locationRepository->assignToVehicle($vehicleId, $locationId);
    }
}
