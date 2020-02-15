<?php

return [
    /*
    |--------------------------------------------------------------------------
    |   DEBUG MODE
    |--------------------------------------------------------------------------
    |
    |   Here you can adjust the display of error messages.
    |
    |   Supported: true, false
    |
    */

    'debug' => false,

    /*
    |--------------------------------------------------------------------------
    |   DATABASE FILE
    |--------------------------------------------------------------------------
    |
    |   Here you can specify the location of the database file. If a file does
    |   not exist at this location, drawer-count will attempt to create one.
    |
    */

    'database' => 'app/resources/database.sqlite',

    /*
    |--------------------------------------------------------------------------
    |   CURRENCY & LOCALIZATION
    |--------------------------------------------------------------------------
    |
    |   Here you can adjust the currency and number format for displaying
    |   denominations of that currency.
    |
    |   Supported:
    |   currency code   must correspond to file in /app/resources/currency
    |   number format   any RFC 4646 language tags (eg en-US, en-GB)
    |
    */

    'localization' => [
        'currency_code' => 'usd',
        'number_format' => 'en-US'
    ],

    /*
    |--------------------------------------------------------------------------
    |   DISPLAY
    |--------------------------------------------------------------------------
    |
    |   Here you can set the default display order for currency.
    |
    |   Supported: "asc", "desc"
    |
    */

    'display' => [
        'notes' => 'asc',
        'coins' => 'asc',
        'rolls' => 'asc',
        'rares' => 'asc'
    ]
];
