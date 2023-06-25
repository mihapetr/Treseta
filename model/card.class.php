<?php

class Card implements JsonSerializable {

    protected $strength;    // card strength
    protected $value;       // for point summation
    protected $suit;        // character from {s, c, b, d}
    protected $image;       // image file name, i.e. "c1.jpg"

    // used in Hand class for sorting 
    public static function cmp($c1, $c2) {

        // if they are different suits then lex compare suits 
        if($c1 -> suit != $c2 -> suit) {
            return strcmp($c1 -> suit, $c2 -> suit);
        }
        
        // they are the same suit
        if($c1 -> strength < $c2 -> strength) return 1;

        // there are no two cards of the same color that have the same 
        // strength
        return -1;
    }

    function __construct($str, $suit, $val, $img) {

        $this -> strength = $str;
        $this -> value = $val;
        $this -> suit = $suit;
        $this -> image = $img;
    }

    // encodes protected values
    public function jsonSerialize() {

        $vars = get_object_vars($this);
        return $vars;
    }

    // "greather than"
    // returns TRUE if the card is stronger than the argument card
    public static function gt($c1, $c2) {

        if($c1 -> suit === $c2 -> suit and 
            $c1 -> strength > $c2 -> strength) return TRUE;
        else return FALSE;
    }

    // getter for value; needed when counting won points
    function val() {

        return $this -> value;
    }

    // getter for the image location
    // final destination will be the view module
    function img() {

        return $this -> image . ".jpg";
    }

    // for debugging
    function __toString() {
        return sprintf("
            value: %s, 
            suit: %s,
            strength: %s, 
            image: %s
        ", $this->value, $this->suit, $this->strength, $this->image );
    }
}

?>