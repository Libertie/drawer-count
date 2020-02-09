<?php

use App\Core\App;
use App\Controllers\AppController;

require 'core/functions.php';
require 'core/App.php';
require 'app/controllers/AppController.php';
require 'app/models/Currency.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Load the config file

try {
    if (!file_exists('config.php')) {
        throw new Exception();
    } else {
        App::set('config', require 'config.php');
    }
} catch (Exception $e) {
    die('Config file does not exist. Please copy config.sample.php to config.php.');
}


// Load the currency localization file

try {
    $currency = App::get('config')['localization']['currency_code'];
    if (!file_exists('app/resources/currency/' . $currency . '.php')) {
        throw new Exception();
    } else {
        App::set('currency', require 'app/resources/currency/' . $currency . '.php');
    }
} catch (Exception $e) {
    die("Specified currency '{$currency}' does not map to an existing file. Please modify config.php.");
}


// Load the home method
(new AppController())->home();