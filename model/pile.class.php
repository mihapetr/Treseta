<?php

require_once __DIR__ . "/collection.class.php";

// a class reprezenting cards won in the round

class Hand extends Collection {

    // intitialize an empty collection
    function __construct() {

        parent::__construct();
    }

    // returns the sum of points won
    function count() {

    }
}

?>