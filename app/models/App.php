<?php

namespace App\Models;

/*
|--------------------------------------------------------------------------
|   APP OBJECT
|--------------------------------------------------------------------------
|
|   This object provides core functionality to the application. In addition
|   to loading config and localization files, it stores configuration
|   variables used throughout the app.
|
*/

class App
{
    protected static $values;
    public static $number_formatter;

    /**
     *  Constructor
     *
     */
    public function __construct()
    {
        // Load the config file if it exists
        if (file_exists('config.php')) {
            $config = require 'config.php';

            // Store all config variables in the App object
            foreach ($config as $variable => $value) {
                self::set($variable, $value);
            }

        // If a config file doesn't exist yet, die
        } else {
            die('Error: Config file does not exist. Please copy config.sample.php to config.php.');
        }

        // Create and store a localized number formatter
        self::$number_formatter = new \NumberFormatter(
            $config['localization']['number_format'],
            \NumberFormatter::CURRENCY
        );

        // Load the currency localization file if it exists
        $currency = self::get('localization')['currency_code'];
        if (file_exists('app/resources/currency/' . $currency . '.php')) {
            App::set('currency', require 'app/resources/currency/' . $currency . '.php');
            App::set('currency_symbol', self::$number_formatter->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL));
        } else {
            die('Error: Specified currency "'
            . $currency
            . '" does not map to an existing file. Please modify config.php.');
        }
    }

    /**
     *  Set a configuration variable
     *
     *  @param mixed $key A unique key for later retrieval
     *  @param mixed $value A value to be stored
     */
    public static function set($key, $value)
    {
        self::$values[$key] = $value;
    }

    /**
     *  Get a configuration variable
     *
     *  @param mixed $key The key for the desired variable
     *  @return mixed
     */
    public static function get($key)
    {
        if (!array_key_exists($key, self::$values)) {
            throw new \Exception("Application {$key} is not set.");
        }

        return self::$values[$key];
    }

    /**
     *  Format a number as currency
     *  (Note: this is a helper function that should probably be moved to a helper class someday.)
     *
     *  @param int|float $number A number to display as currency
     *  @return string A pretty currency string
     */
    public static function formatCurrency($number)
    {
        return self::$number_formatter->format($number / 100);
    }

}
