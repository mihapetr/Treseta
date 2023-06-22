<?php

require_once __DIR__ . "/collection.class.php";

// a class reprezenting cards won in the round

class Pile extends Collection {

    // intitialize an empty collection
    function __construct() {

        parent::__construct();
    }

    // adds a card to the pile
    function add($card) {
        $this -> cards[] = $card;
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