<?php
require_once __DIR__ . "/card.class.php";

// classes Deck, Hand, Pile will be derived from this one

class Collection {

    protected $cards;   // an ordered collection of cards, a list

    function __construct() {
        $this -> cards = [];
    }

    // getter for the collection
    function cards() {
        return $this -> cards;
    }

    // empty the collection
    function empty() {
        $this -> cards = [];
    }
}

?>