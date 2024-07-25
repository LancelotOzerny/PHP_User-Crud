<?php
namespace App\Classes\Traits;

trait Singleton
{
    private static $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function Instance() : self | null
    {
        if (self::$instance == null)
        {
            self::$instance = new static();
        }

        return self::$instance;
    }
}