<?php

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $config = require __DIR__ . '/../config/database.php';

            if ($config['driver'] === 'sqlite') {
                $dbDir = dirname($config['database']);
                if (!is_dir($dbDir)) {
                    mkdir($dbDir, 0755, true);
                }

                $dsn = "sqlite:{$config['database']}";
                self::$connection = new PDO($dsn, null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            }
        }

        return self::$connection;
    }
}
