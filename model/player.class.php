<?php

require_once __DIR__ . "/hand.class.php";
require_once __DIR__ . "/pile.class.php";


class Player {

    protected $name;
    protected $position;    // position at the table

    // every player has a hand of cards and a pile of won cards
    protected $hand;
    protected $pile;

    function __construct($name) {

        $this -> name = $name;
        $this -> hand = new Hand;
        $this -> pile = new Pile;
    }
}