<?php

declare(strict_types=1);

namespace Fulll\Infra\CLI;
use Exception;

class FleetArgumentValidator extends ArgumentValidator
{
    private const SUPPORTED_COMMANDS = [
        'create',
        'register-vehicle',
        'localize-vehicle',
    ];

    /**
     * @throws Exception
     */
    public static function getCommand($arguments)
    {
        if (!isset($arguments[0])) {
            self::displaySupportedCommands();
            throw new Exception("command is missing");
        }

        return $arguments[0];
    }

    /**
     * @throws Exception
     */
    public static function checkIsSupported(string $command): void
    {
        if (!in_array($command, self::SUPPORTED_COMMANDS, true)) {
            self::displaySupportedCommands();
            throw new Exception("command $command not supported");
        }
    }

    public static function displaySupportedCommands()
    {
        echo "Supported Commands :" . PHP_EOL;
        foreach (self::SUPPORTED_COMMANDS as $command) {
            echo " - $command" . PHP_EOL;
        }
    }
}