<?php

function dd($var)
{
    echo '<pre>';
    print_r($var);
    die;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Load the config file

try {
    if (!file_exists('config.php'))
        throw new Exception();
    else
        $app['config'] = require 'config.php';

} catch (Exception $e) {
    die("Config file does not exist. Please copy config.sample.php to config.php.");
}


// Load the currency localization file

try {
    $currency = $app['config']['localization']['currency_code'];
    if (!file_exists('app/resources/currency/'.$currency.'.php'))
        throw new Exception();
    else
        $app['currency'] = require 'app/resources/currency/'.$currency.'.php';

} catch (Exception $e) {
    die("Specified currency '{$currency}' does not map to an existing file. Please modify config.php.");
}


// Split coins array into loose and rolled values

$app['currency'] = array_merge([
    'notes' => [],
    'coins' => [],
    'rolls' => [],
    'rares' => []
], $app['currency']);

array_walk(
    $app['currency']['coins'],
    function(&$value, $name) use (&$app) {
        // If there is a rolled value, capture it
        if ($value[1])
            list($app['currency']['rolls'][$name], $value) = array_reverse($value);
        // Otherwise, flatten the array
        else
            $value = $value[0];
    }
);


// Remove any empty types (eg rolled coins)

$app['currency'] = array_filter($app['currency']);


// Reorder denominations for display

foreach ($app['currency'] AS $type => &$denominations) {

    if ($app['config']['display'][$type] == 'asc')
        asort($denominations);

    else if ($app['config']['display'][$type] == 'desc')
        arsort($denominations);

}
// This can be removed once I implement namespaces
unset($type, $denominations);