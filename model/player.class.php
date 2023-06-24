<?php

require_once __DIR__ . "/hand.class.php";
require_once __DIR__ . "/pile.class.php";


class Player implements JsonSerializable {

    protected $name;
    protected $position;    // position at the table

    // every player has a hand of cards and a pile of won cards
    protected $hand;
    protected $pile;

    function __construct($name, $position) {

        $this -> name = $name;
        $this -> position = $position;
        $this -> hand = new Hand;
        $this -> pile = new Pile;
    }

    // encodes protected values
    public function jsonSerialize() {

        $vars = get_object_vars($this);
        return $vars;
    }

    // getter for position
    function position() {
        
        return $this -> position;
    }

    function take($card) {

        $this -> hand -> add($card);
    }
}