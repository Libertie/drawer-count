<?php

namespace App\Core;

class App
{
    protected static $values = [];

    public static function set($key, $value)
    {
        self::$values[$key] = $value;
    }

    public static function get($key)
    {
        if (!array_key_exists($key, self::$values)) {
            throw new \Exception("Application {$key} is not set.");
        }

        return self::$values[$key];
    }
}