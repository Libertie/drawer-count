<?php

use App\Models\App;
use App\Models\Database;
use App\Controllers\AppController;

require 'app/functions.php';
require 'app/models/App.php';
require 'app/models/Database.php';
require 'app/models/Currency.php';
require 'app/controllers/AppController.php';

// Start session
session_start();

// Construct the App Model
$app = new APP();

// Set error handling for debug mode
if ($app->get('debug')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Construct the Database
$app->set('database', new Database($app->get('database')));

// Load the App Controller home method
(new AppController())->home();
