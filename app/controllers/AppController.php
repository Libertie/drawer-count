<?php
namespace App\Controllers;

use App\Models\App;
use App\Models\Currency;

class AppController
{
    public function home()
    {
        // Get configured sort orders
        $sorts = App::get('display');

        // Create a sorted currency object
        $currency = (new Currency(App::get('currency')))
            ->sort($sorts);

        require 'app/views/index.view.php';
    }
}
