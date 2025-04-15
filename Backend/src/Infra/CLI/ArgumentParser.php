<?php

declare(strict_types=1);

namespace Fulll\Infra\CLI;

use Exception;

class ArgumentParser
{
    /**
     * @throws Exception
     */
    public static function float(string $value): float
    {
        if (!is_numeric($value)) {
            throw new Exception("Argument '$value' must be a float.");
        }

        return floatval($value);
    }

    /**
     * @throws Exception
     */
    public static function optionalFloat(?string $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return self::float($value);
    }
}
