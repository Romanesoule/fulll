<?php

declare(strict_types=1);

namespace Fulll\Infra\CLI;

use Exception;
use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\Domain\Repository\FleetRepositoryInterface;

class CommandHandler
{
    /**
     * @throws Exception
     */
    public static function handle(string $command, array $arguments, FleetRepositoryInterface $repository): void
    {
        switch ($command) {
            case 'create':
                self::createFleet($arguments, $repository);
                break;
            case 'register-vehicle':
                self::registerVehicle($arguments, $repository);
                break;
            case 'localize-vehicle':
                self::localizeVehicle($arguments, $repository);
                break;
            default:
                throw new Exception("Unknown command: $command");
        }
    }

    /**
     * @throws Exception
     */
    static private function createFleet(array $arguments, FleetRepositoryInterface $repository): void
    {
        ArgumentValidator::checkHasEnoughArguments($arguments, 2);
        $command = new CreateFleetCommand($repository);
        $fleetId = $command->execute($arguments[1]);
        echo "fleet id : $fleetId";
    }

    /**
     * @throws Exception
     */
    static private function registerVehicle(array $arguments, FleetRepositoryInterface $repository): void
    {
        ArgumentValidator::checkHasEnoughArguments($arguments, 3);
        $command = new RegisterVehicleCommand($repository);
        $command->execute($arguments[1], $arguments[2]);
    }

    /**
     * @throws Exception
     */
    static public function localizeVehicle(array $arguments, FleetRepositoryInterface $repository): void
    {
        ArgumentValidator::checkHasEnoughArguments($arguments, 5);
        $command = new ParkVehicleCommand($repository);
        $latitude = ArgumentParser::optionalFloat($arguments[3]);
        $longitude = ArgumentParser::optionalFloat($arguments[4]);
        $altitude = isset($arguments[5]) ? ArgumentParser::optionalFloat($arguments[5]) : null;
        $command->execute($arguments[1], $arguments[2], $latitude, $longitude, $altitude);
    }

}