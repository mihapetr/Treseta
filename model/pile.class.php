<?php

require_once __DIR__ . "/collection.class.php";

// a class reprezenting cards won in the round

class Pile extends Collection implements JsonSerializable {

    // intitialize an empty collection
    function __construct() {

        parent::__construct();
    }

    // encodes protected values
    public function jsonSerialize() {

        $vars = get_object_vars($this);
        return $vars;
    }

    // setter used by loadJSON function
    function __set($prop, $val) {

        if(property_exists($this, $prop)) $this -> $prop = $val;
    }

    // adds cards from the list to the pile
    function add($won) {
        foreach ($won as $key => $card) {
            $this -> cards[] = $card;
        }
    }

    // returns the sum of bela points won
    function count() {

        $sum = 0;

        foreach ($cards as $key => $card) {
            $sum += $card -> val();
        }

        return $sum;
    }
}

?>