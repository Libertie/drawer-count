<?php

namespace App\Models;

class Currency
{
    private $denominations = [];
    private static $formatter = null;
    private static $symbol = 'USD';

    public function __construct($denominations, $format)
    {
        $this->denominations = $this->splitCoins($denominations);
        self::$formatter = new \NumberFormatter($format, \NumberFormatter::CURRENCY);
        self::$symbol = self::$formatter->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
    }

    /*
    |
    |   Sort currency denominations
    |
    */
    public function sort($display)
    {
        foreach ($this->denominations as $type => &$variants) {
            if ($display[$type] == 'asc') {
                asort($variants);
            } elseif ($display[$type] == 'desc') {
                arsort($variants);
            }
        }

        return $this;
    }

    /*
    |
    |   Split coins array into loose and rolled values
    |
    */
    private function splitCoins($denominations)
    {
        $denominations = array_merge([
            'notes' => [],
            'coins' => [],
            'rolls' => [],
            'rares' => []
        ], $denominations);

        array_walk(
            $denominations['coins'],
            function (&$value, $name) use (&$denominations) {
                // If there is a rolled value, capture it
                if ($value[1]) {
                    list($denominations['rolls'][$name], $value) = array_reverse($value);
                }
                // Otherwise, flatten the array
                else {
                    $value = $value[0];
                }
            }
        );

        return array_filter($denominations);
    }

    /*
    |
    |   Format a number according to the localization settings
    |
    */
    public function format($number)
    {
        return self::$formatter->format($number);
    }

    public function getDenominations($flip_array = false)
    {
        if (!$flip_array) {
            return $this->denominations;
        } else {
            $r = $this->denominations;
            return array_map(function (&$type) {
                array_walk($type, function (&$item) {
                    $item = sprintf('%06d', $item * 100);
                });
                return array_flip($type);
            }, $r);
        }
    }

    public function getSymbol()
    {
        return self::$symbol;
    }
}
