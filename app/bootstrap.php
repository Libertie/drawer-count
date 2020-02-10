<?php

use App\Models\App;
use App\Controllers\AppController;

require 'app/functions.php';
require 'app/models/App.php';
require 'app/models/Database.php';
require 'app/models/Currency.php';
require 'app/controllers/AppController.php';


// Construct the App Model
$app = new APP();

// Set error handling for debug mode
if ($app->get('config')['debug']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Load the App Controller home method
(new AppController())->home();