<?php

require_once __DIR__ . "/collection.class.php";

class Hand extends Collection implements JsonSerializable {

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
    function throw($which) {

        $chosen =  $this -> cards[$which];
        unset($this -> cards[$which]);
        return $chosen;
    }

}

?>