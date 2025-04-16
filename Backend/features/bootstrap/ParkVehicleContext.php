<?php

namespace Features\Bootstrap;

use Behat\Behat\Context\Context;
use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\Domain\Fleet\FleetRepositoryInterface;
use Fulll\Domain\Location\Location;
use Fulll\Domain\Location\LocationRepositoryInterface;
use Fulll\Domain\Vehicle\Vehicle;
use Fulll\Domain\Vehicle\VehicleRepositoryInterface;
use Fulll\Infra\Database\DatabaseManager;
use Fulll\Infra\Repository\FleetSqliteRepository;
use Fulll\Infra\Repository\VehicleSqliteRepository;
use Fulll\Infra\Repository\LocationSqliteRepository;
use PDO;
use Exception;

class ParkVehicleContext implements Context
{

    private VehicleRepositoryInterface $vehicleRepo;
    private LocationRepositoryInterface $locationRepo;

    private ?ParkVehicleCommand $command = null;
    private ?CreateFleetCommand $createFleetCommand = null;
    private ?RegisterVehicleCommand $registerCommand = null;

    private ?Vehicle $vehicle = null;
    private string $fleetId;
    private string $plateNumber = 'AZE7894';

    private ?Exception $thrownException = null;
    private Location $location;

    /**
     * @BeforeScenario
     */
    public function setup(): void
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../database_test.sqlite');
        DatabaseManager::initialize($pdo);
        DatabaseManager::clear($pdo);

        $fleetRepo = new FleetSqliteRepository($pdo);
        $this->vehicleRepo = new VehicleSqliteRepository($pdo);
        $this->locationRepo = new LocationSqliteRepository($pdo);

        $this->command = new ParkVehicleCommand($fleetRepo, $this->locationRepo, $this->vehicleRepo);
        $this->createFleetCommand = new CreateFleetCommand($fleetRepo);
        $this->registerCommand = new RegisterVehicleCommand($fleetRepo, $this->vehicleRepo);
    }

    /**
     * @Given my fleet
     * @throws Exception
     */
    public function myFleet(): void
    {
        $this->fleetId = $this->createFleetCommand->execute('1');
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle(): void
    {
        $this->vehicle = new Vehicle($this->plateNumber);
    }

    /**
     * @Given I have registered this vehicle into my fleet
     * @throws Exception
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->registerCommand->execute($this->fleetId, $this->vehicle->getPlateNumber());
    }

    /**
     * @Given a location
     */
    public function aLocation(): void
    {
        $this->location = new Location(58.78945, 8.12345);
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->command->execute($this->fleetId, $this->plateNumber,
                $this->location->getLatitude(),
                $this->location->getLongitude(),
                $this->location->getLatitude());
        } catch (Exception $e) {
            $this->thrownException = $e;
        }
    }

    /**
     * @Then the known location of my vehicle should verify this location
     * @throws Exception
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        $vehicle = $this->vehicleRepo->getByPlateAndFleet($this->vehicle->getPlateNumber(), $this->fleetId);
        $lastLocation = $this->locationRepo->getLatestForVehicle($vehicle->getId());
        $this->location->isEquals($lastLocation);
    }

    /**
     * @Given my vehicle has been parked into this location
     * @throws Exception
     */
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        $this->command->execute(
            $this->fleetId, $this->plateNumber,
            $this->location->getLatitude(),
            $this->location->getLongitude(),
            $this->location->getLatitude()
        );

        $vehicle = $this->vehicleRepo->getByPlateAndFleet($this->vehicle->getPlateNumber(), $this->fleetId);
        $lastLocation = $this->locationRepo->getLatestForVehicle($vehicle->getId());
        $this->location->isEquals($lastLocation);
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->command->execute($this->fleetId, $this->plateNumber, $this->location->getLatitude(),
                $this->location->getLongitude(),
                $this->location->getLatitude());
        } catch (Exception $e) {
            $this->thrownException = $e;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     * @throws Exception
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        if ($this->thrownException === null) {
            throw new Exception("Expected an exception, but none was thrown.");
        }
    }
}
