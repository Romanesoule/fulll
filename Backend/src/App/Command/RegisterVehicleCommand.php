<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Fleet\FleetRepositoryInterface;
use Fulll\Domain\Vehicle\Vehicle;
use Fulll\Domain\Vehicle\VehicleRepositoryInterface;
use Exception;


class RegisterVehicleCommand
{
    private FleetRepositoryInterface $fleetRepository;
    private VehicleRepositoryInterface $vehicleRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository, VehicleRepositoryInterface $vehicleRepository)
    {
        $this->fleetRepository = $fleetRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $fleetId, string $plateNumber): void
    {
        if (!$this->fleetRepository->exists($fleetId)) {
            throw new Exception("this fleet does not exists");
        }

        if ($this->vehicleRepository->existsInFleet($plateNumber, $fleetId)) {
            throw new Exception("this vehicle $plateNumber is already registered in this fleet");
        }

        $fleet = $this->fleetRepository->getById($fleetId);
        $fleet->registerVehicle($plateNumber);
        $vehicle = new Vehicle($plateNumber);
        $this->vehicleRepository->save($vehicle, $fleetId);
    }
}
