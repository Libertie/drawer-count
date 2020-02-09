<?php

namespace App\Models;

class Currency
{
    public function __construct($denominations)
    {
        $this->denominations = $this->splitCoins($denominations);
    }

    /*
    |
    |   Sort currency denominations for display
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
}