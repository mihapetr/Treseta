<?php

require_once __DIR__ . "/hand.class.php";
require_once __DIR__ . "/pile.class.php";
require_once __DIR__ . "/call.class.php";


class Player implements JsonSerializable {

    protected $name;
    protected $position;    // position at the table

    protected $call;        // cards for bonus points
    // every player has a hand of cards and a pile of won cards
    protected $hand;
    protected $pile;

    function __construct($name, $position) {

        $this -> name = $name;
        $this -> position = $position;
        $this -> hand = new Hand;
        $this -> pile = new Pile;
        $this -> call = new Call;
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

    // getter for position
    function position() {
        
        return $this -> position;
    }

    // for dealing cards
    function take($card) {

        $this -> hand -> add($card);
    }

    // hand getter
    function hand() {

        return $this -> hand;
    }

    function pile() {

        return $this -> pile;
    }

    function name() {

        return $this -> name;
    }

    function call() {
        return $this -> call;
    }

    // for playing a card
    function play($which) {

        return $this -> hand -> throw($which);
    }
}