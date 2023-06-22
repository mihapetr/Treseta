<?php

require_once __DIR__ . "/collection.class.php";

class Hand extends Collection {

    // intitialize an empty collection
    function __construct() {

        parent::__construct();
    }

    // adds a card to the players hand
    function add($card) {

        $this -> cards[] = $card;
    }

    // order cards by suit and strength descending
    function sort() {

        // calls a static function of class Card for comparing cards
        usort($this -> cards, [Card::class, "cmp"]);  
    }

    // plays (returns) a card from a player's hand
    function play($which) {
        return $this -> cards[$which];
    }
}

?>