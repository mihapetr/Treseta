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
}

?>