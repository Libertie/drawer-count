<?php

namespace App\Controllers;

use App\Models\App;
use App\Models\Drawer;

/*
|--------------------------------------------------------------------------
|   APP CONTROLLER
|--------------------------------------------------------------------------
|
|   This object mediates between the app's views and models
|
*/

class AppController
{
    /**
     *  Application home screen
     *
     */
    public function home()
    {
        if (isset($_POST['total'])) {
            $this->save();
        }

        // Create a new, empty drawer
        $drawer = (new Drawer(App::get('currency')))
            ->sort($sorts = App::get('display'));

        // Get saved drawers
        $database = App::get('database');
        $drawers = $database->getDrawers();

        // Show the home page view
        require 'app/views/index.view.php';
    }

    /**
     *  Save a drawer
     *
     */
    public function save()
    {
        $database = App::get('database');

        $drawer = [
            'total' => $_POST['total'],
            'expected' => ($_POST['expected'] * 100) ?: null,
            'discrepancy' => $_POST['discrepancy'] ?: null,
            'details' => json_encode(array_intersect_key($_POST, array_flip(['notes', 'coins', 'rolls', 'rares'])))
        ];

        // If insert is successful, redirect back to the homepage
        if ($database->insertDrawer($drawer)) {
            redirect('/', 'Drawer count saved!');
        } else {
            die('Error: Something has gone wrong while attempting to save your drawer.');
        }
    }
}
