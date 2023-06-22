<?php

require_once __DIR__ . "/collection.class.php";

class Hand extends Collection {

    // intitialize an empty collection
    function __construct() {

        parent::__construct();
    }

    // order cards by suit and strength descending
    function sort() {
        
    }

    // plays (returns) a card from a player's hand
    function play($which) {
        return $this -> cards[$which];
    }
}

?>