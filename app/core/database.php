<?php
namespace App\Core;

use App\Config;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (self::$connection === null)
        {
            self::$connection = new \PDO(
                'mysql:host=' . Config::$dbHost . ';dbname=' . Config::$dbName,
                Config::$dbUser,
                Config::$dbPass
            );
        }

        return self::$connection;
    }
}