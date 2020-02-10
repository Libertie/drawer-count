<?php

namespace App\Models;

use \Exception;

class App
{
    protected static $values = [];

    public function __construct()
    {
        // Load config file
        try {
            if (! file_exists('config.php')) {
                throw new Exception();
            } else {
                self::set('config', require 'config.php');
            }
        } catch (Exception $e) {
            die('Config file does not exist. Please copy config.sample.php to config.php.');
        }

        // Load currency localization file
        try {
            $currency = self::get('config')['localization']['currency_code'];
            if (! file_exists('app/resources/currency/' . $currency . '.php')) {
                throw new Exception();
            } else {
                App::set('currency', require 'app/resources/currency/' . $currency . '.php');
            }
        } catch (Exception $e) {
            die("Specified currency '{$currency}' does not map to an existing file. Please modify config.php.");
        }
    }

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