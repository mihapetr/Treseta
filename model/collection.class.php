<?php
require_once __DIR__ . "/card.class.php";

// classes Deck, Hand, Pile will be derived from this one

class Collection implements JsonSerializable {

    protected $cards;   // an ordered collection of cards, a list

    function __construct() {
        $this -> cards = [];
    }

    // encodes protected values
    public function jsonSerialize() {

        $vars = get_object_vars($this);
        return $vars;
    }

    // getter for the collection
    function cards() {
        return $this -> cards;
    }

    // empty the collection
    function empty() {
        $this -> cards = [];
    }

    // check if there are cards
    function isEmpty() {

        if(count($this -> cards) == 0) return TRUE;
        else return FALSE;
    }
}

?>