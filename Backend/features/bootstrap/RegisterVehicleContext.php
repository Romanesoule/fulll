<?php

namespace Features\Bootstrap;

use Behat\Behat\Context\Context;
use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\Domain\Vehicle\Vehicle;
use Fulll\Domain\Vehicle\VehicleRepositoryInterface;
use Fulll\Infra\Database\DatabaseManager;
use Fulll\Infra\Repository\FleetSqliteRepository;
use Fulll\Infra\Repository\VehicleSqliteRepository;
use PDO;
use Exception;

class RegisterVehicleContext implements Context
{

    private VehicleRepositoryInterface $vehicleRepo;

    private ?RegisterVehicleCommand $command = null;
    private ?CreateFleetCommand $createFleetCommand = null;

    private ?Vehicle $vehicle = null;
    private string $fleetId;
    private string $otherFleetId;
    private string $plateNumber = 'NBV32165';

    private ?Exception $thrownException = null;

    /**
     * @BeforeScenario
     */
    public function setup(): void
    {
        $pdo = new PDO('sqlite:' .  __DIR__ . '/../../database_test.sqlite');

        DatabaseManager::initialize($pdo);
        DatabaseManager::clear($pdo);

        $fleetRepo = new FleetSqliteRepository($pdo);
        $this->vehicleRepo = new VehicleSqliteRepository($pdo);

        $this->command = new RegisterVehicleCommand($fleetRepo, $this->vehicleRepo);
        $this->createFleetCommand = new CreateFleetCommand($fleetRepo);
    }

    /**
     * @Given my fleet
     * @throws Exception
     */
    public function myFleet(): void
    {
        $this->fleetId = $this->createFleetCommand->execute('user_1');
    }

    /**
     * @Given the fleet of another user
     * @throws Exception
     */
    public function andTheFleetOfAnotherUser(): void
    {
        $this->otherFleetId = $this->createFleetCommand->execute('user_2');
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
        $this->command->execute($this->fleetId, $this->vehicle->getPlateNumber());
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     * @throws Exception
     */
    public function thisVehicleHasBeenRegisteredIntoOther(): void
    {
        $this->command->execute($this->otherFleetId, $this->vehicle->getPlateNumber());
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        try {
            $this->command->execute($this->fleetId, $this->vehicle->getPlateNumber());
        } catch (Exception $e) {
            $this->thrownException = $e;
        }
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        try {
            $this->command->execute($this->fleetId, $this->vehicle->getPlateNumber());
        } catch (Exception $e) {
            $this->thrownException = $e;
        }
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     * @throws Exception
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $this->vehicleRepo->getByPlateAndFleet($this->vehicle->getPlateNumber(), $this->fleetId);
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     * @throws Exception
     */
    public function iShouldBeInformedThisVehicleAlreadyRegistered(): void
    {
        if ($this->thrownException === null) {
            throw new Exception("Expected an exception, but none was thrown.");
        }
    }
}
