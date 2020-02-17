<?php

namespace App\Models;

/*
|--------------------------------------------------------------------------
|   DENOMINATION OBJECT
|--------------------------------------------------------------------------
|
|   This object defines a currency denomination that can be found within a
|   drawer. Every denomination has a name, type, worth, and quantity.
|
*/

class Denomination
{
    private $name;
    private $type;
    private $worth;
    private $quantity;

    /**
     *  Constructor
     *
     *  @param string $name The denomination name
     *  @param string $type The denomination type (e.g. notes, rolls, rares)
     *  @param int $worth The denomination value, in cents (e.g. $1 = 100)
     *  @param int $quantity The quantity of the denomination present
     */
    public function __construct(string $name, string $type, int $worth, int $quantity = 0)
    {
        $this->name = $name;
        $this->type = $type;
        $this->worth = $worth;
        $this->quantity = $quantity;
    }

    /**
     *  Get denomination name
     *
     *  @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     *  Get denomination worth
     *
     *  @return int
     */
    public function worth()
    {
        return $this->worth;
    }

    /**
     *  Get denomination quantity
     *
     *  @return int
     */
    public function quantity()
    {
        return $this->quantity;
    }

    /**
     *  Get the sum worth of the denomination's quantity
     *
     *  @return int
     */
    public function sum()
    {
        return $this->worth * $this->quantity;
    }
}
