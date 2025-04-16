<?php

declare(strict_types=1);

namespace Fulll\Infra\Database;

use PDO;

class DatabaseManager
{
    public static function initialize(PDO $pdo): void
    {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('PRAGMA foreign_keys = ON;');

        $schemaPath = __DIR__ . '/schema.sql';

        if (!file_exists($schemaPath)) {
            throw new \RuntimeException("Schema SQL file not found at: $schemaPath");
        }

        $sql = file_get_contents($schemaPath);
        $pdo->exec($sql);
    }

    public static function clear(PDO $pdo): void
    {
        $pdo->exec('DELETE FROM vehicle_locations');
        $pdo->exec('DELETE FROM locations');
        $pdo->exec('DELETE FROM vehicles');
        $pdo->exec('DELETE FROM fleets');
    }
}
