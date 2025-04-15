<?php

declare(strict_types=1);

namespace Fulll\Infra\CLI;
use Exception;

class ArgumentValidator
{
    /**
     * @throws Exception
     */
    public static function checkHasEnoughArguments(array $argv, int $expectedSize): void
    {
        if (count($argv) < $expectedSize){
            throw new Exception("missing arguments $expectedSize expected");
        }
    }
}