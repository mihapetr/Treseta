<?php

class Card {

    protected $strength;    // card strength
    protected $value;       // for point summation
    protected $suit;        // character from {s, c, b, d}
    protected $image;       // image file name, i.e. "c1.jpg"

    function __construct($str, $suit, $val, $img) {
        $this -> strength = $str;
        $this -> value = $val;
        $this -> suit = $suit;
        $this -> image = $img;
    }

    // "greather than"
    // returns TRUE if the card is stronger than the argument card
    function gt($card) {
        if($this -> suit === $card -> suit and 
            $this -> strength > $card -> strength) return TRUE;
        else return FALSE;
    }

    // getter for value; needed when counting won points
    function val() {
        return $this -> value;
    }

    // getter for the image location
    // will be called by the controller, hence the path concatenations
    function img() {
        // requires __DIR__ when called from controller
        return  "/../app/card_art/" . $this -> image . ".jpg";
    }
}

?>