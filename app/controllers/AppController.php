<?php
namespace App\Controllers;

use App\Models\App;
use App\Models\Currency;

class AppController
{
    public function home()
    {
        if (isset($_POST['total'])) {
            $this->save();
        }

        // Get configured sort orders
        $sorts = App::get('display');

        // Create a sorted currency object
        $currency = (new Currency(App::get('currency')))
            ->sort($sorts);

        // Get saved drawers
        $database = App::get('database');
        $drawers = $database->getDrawers();

        require 'app/views/index.view.php';
    }

    public function save()
    {
        $database = App::get('database');
    
        $drawer = [
            'total' => $_POST['total'],
            'expected' => $_POST['expected'] ?: null,
            'discrepancy' => $_POST['discrepancy'] ?: null,
            'details' => json_encode(array_intersect_key($_POST, array_flip([
                'notes',
                'coins',
                'rolls',
                'rares'
            ])))
        ];

        if ($database->insertDrawer($drawer)) {
            $_SESSION["msg"] = "Drawer count saved!";
        }

    }
}
