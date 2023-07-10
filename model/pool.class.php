<?php

require_once __DIR__ . "/collection.class.php";

// a class reprezenting cards on the table

class Pool extends Collection implements JsonSerializable {

    protected $first;       // position of the first card (player)
    protected $empty;
    protected $winner;

    // intitialize an empty collection
    function __construct() {

        parent::__construct();
        $this -> first = null;
        $this -> cards = array_fill(0, 4, new Card("","","",""));
        $this -> empty = true;  // if all cards on the table are empty cards
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

    // getter
    function lastWinner() {
        return $this -> winner;
    }

    // player on $position plays a card with index $card
    function play($position, $card) {

        //if(isset($this -> cards[$position])) throw new Exception("Card already on the table!", 1);
        
        if($this -> empty) {
            $this -> first = $position;
            $this -> empty = false;
        }
        $this -> cards[$position] = $card;
    }

    // returns the position of the player who won the trick
    function winner() {

        //if(count($this -> cards) != 4) throw new Exception("Not enough cards in the pool", 1);
        
        $winner = $this -> first;
        for ($i=1; $i <= 3; $i++) {
            $contestor =  ($winner + $i) % 4;
            $winnerCard = $this -> cards[$winner];
            $contestorCard = $this -> cards[$contestor];
            if(Card::gt($contestorCard, $winnerCard)) $winner = $contestor;
        }

        $this -> winner = $winner;
        return $winner;
    }

    // check if it is legal for a $player to throw a $card
    function isLegal($player, $card) {

        if($this -> empty) return true;     // any card can be first

        $suit = $this -> cards[$this -> first] -> suit;     // pool suit
        if($card -> suit == $suit) return TRUE;
        else {
            $handCards = $player -> hand() -> cards();
            foreach ($handCards as $key => $card) {
                if($card -> suit == $suit) return FALSE; // suit has to be followed
            }
            return TRUE; // there is no card of the pool suit
        }
    }

    // empties the pool
    function collect() {

        $cards = $this -> cards;
        $this -> first = null;
        $this -> cards = array_fill(0, 4, new Card("","","",""));
        $this -> empty = true;  // if all cards on the table are empty cards
        return $cards;
    }

    function isEmpty() {
        
        if ($this -> empty) return true;
        return false;
    }
}