<?php

namespace App\Models;

/*
|--------------------------------------------------------------------------
|   DRAWER OBJECT
|--------------------------------------------------------------------------
|
|   This object defines a cash register drawer. The public properties map
|   to columns in the drawer database table. The private properties
|   describe the specific denominations held within the drawer. These can
|   be changed with adjustments to the localization within the config file.
|
*/

class Drawer
{
    public $id;
    public $total;
    public $expected;
    public $discrepancy;
    public $note;
    public $created;

    private $denomination_types;
    private $coins;
    private $rolls;
    private $notes;
    private $rares;

    /**
     *  Constructor
     *
     *  @param array $currency A nested array of denominations
     *  @param array $properties A list of Object properties to override
     */
    public function __construct(array $currency, $properties = [])
    {
        $this->total = $this->expected = $this->discrepancy = 0;
        $this->coins = $this->rolls = $this->notes = $this->rares = [];
        $this->denomination_types = ['notes', 'coins', 'rolls', 'rares'];

        // Unpack json data from database, if provided. We'll use this below to set drawer denomination quantities.
        if (isset($properties['counts'])) {
            $counts = json_decode($properties['counts'], true);
            unset($properties['counts']);
        }

        // Loop through the currency information from the config file to give this drawer all the correct denominations
        foreach ($currency as $type => $denominations) {
            foreach ($denominations as $name => $worth) {

                // If a denomination has an array of values, treat the second one as a "rolled" variation
                // (e.g. a roll of quarters)
                if (is_array($worth)) {
                    // Ignore the variation if no value was specified
                    if ($worth[1]) {
                        $this->rolls[] = new Denomination(
                            $name,
                            'rolls',
                            $w = intval(array_pop($worth) * 100),
                            intval($counts['rolls'][strval(sprintf('%06d', $w))] ?? 0)
                        );
                    }
                    $worth = $worth[0];
                }

                // Create the Denomination object and add it to the appropriate type property of the Drawer
                $this->$type[] = new Denomination(
                    $name,
                    $type,
                    $w = intval($worth * 100),
                    intval($counts[$type][strval(sprintf('%06d', $w))] ?? 0)
                );
            }
        }

        // Set existing drawer properties (e.g. id, total, created, notes, etc)
        foreach ($properties as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     *  Calculate drawer total and discrepancy
     *
     *  @return int
     */
    public function calculate()
    {
        $this->total = 0;

        // Loop through the denomination types
        foreach ($this->denomination_types as $type) {

            // For each denomination type add the sum of the denomination sums
            $this->total += array_sum(array_map(function ($denomination) {
                return $denomination->sum();
            }, $this->$type));

        };

        // If an expected count is known, calculate a discrepancy
        if ($this->expected) {
            $this->discrepancy = $this->total - $this->discrepancy;
        }

        return $this->total;
    }

    /**
     *  Check this drawer for quantity of a specified denomination type
     *
     *  @param string $type A requested denomination type
     *  @return boolean
     */
    public function checkDenomination($type)
    {
        return array_reduce($this->denominations($type), function ($carry, $item) {
            return $carry + $item->quantity();
        }) ? true : false;
    }

    /**
     *  List this drawer's Denominations for a given denomination type
     *
     *  @param string $type A requested denomination type
     *  @return array
     */
    public function denominations($type)
    {
        return $this->$type;
    }

    /**
     *  List drawer denomination types
     *
     *  @return array
     */
    public function denominationTypes()
    {
        return $this->denomination_types;
    }

    /**
     *  Sort drawer denominations
     *
     *  @param array $display A list of types with sort logic (e.g. 'coins' => 'asc')
     *  @return $this
     */
    public function sort(array $display)
    {
        foreach ($this->denomination_types as $type) {
            usort($this->$type, function ($a, $b) use ($type, $display) {
                $comp = ($a->worth() < $b->worth()) ? -1 : 1;
                return $display[$type] == 'asc' ? $comp : -$comp;
            });
        }

        return $this;
    }
}
