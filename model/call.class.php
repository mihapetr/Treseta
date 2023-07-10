<?php

require_once __DIR__ . "/collection.class.php";

// a class reprezenting cards won in the round

class Call extends Collection implements JsonSerializable {

    public static $combinations = null;

    private $value;

    // intitialize an empty collection
    function __construct() {

        parent::__construct();
        $this -> value = 0;
    }

    // encodes protected values
    public function jsonSerialize() {

        $vars = get_object_vars($this);
        return $vars;
    }

    // for calling, all possible calls
    public static function combinations() {
        
        if(($it = Call::$combinations) != null) return $it;

        $combos = [];
        $suits = ["b","c","d","s"];

        // 123 x cbsd
        for ($i=0; $i < 4; $i++) { 
            $combos[] = [$suits[$i]."1", $suits[$i]."2", $suits[$i]."3"];
        }
        
        // 1111, 2222, 3333
        for ($i=1; $i <= 3; $i++) { 
            $combo = [];
            for ($j=0; $j < 4; $j++) { 
                $combo[] = $suits[$j] . $i;
            }
            $combos[] = $combo;
        }

        // 111, 222, 333
        for ($odd=0; $odd < 4; $odd++) { 
            for ($lab=1; $lab <= 3; $lab++) { 
                $combo = [];
                for ($i=0; $i < 4; $i++) { 
                    if($i != $odd) $combo[] = $suits[$i] . $lab; 
                }
                $combos[] = $combo;
            }
        }

        Call::$combinations = $combos;
        return $combos;
    }

    // setter used by loadJSON function?
    function __set($prop, $val) {

        if(property_exists($this, $prop)) $this -> $prop = $val;
    }

    // adds or removes cards from player calls
    function add_or_remove($input_card) {

        foreach ($this -> cards as $key => $card) {
            if($input_card -> image() == $card -> image()) {
                // card is already in the collection and the user wants it removed
                unset($this -> cards[$key]);
                return ["removed", $this -> cards];
            }
        }

        // the card in question is not in the set, add it
        $this -> cards[] = $input_card;
        return ["added", $this -> cards];
    } 

    // returns the value of the calling cards in this collection
    // points are punats, not belas
    // needs to be called while the hand is still full
    function evaluate() {

        $combos = Call::combinations();
        $sum = 0;       // for the final result
        $labels = [];   // labels in this collection
        $taboo = [];    // if a player has x,x,x it is not valid to have x,x,x,x
        foreach ($this -> cards as $key => $card) {
            $labels[] = $card -> image();
        }

        foreach ($combos as $key => $combo) {
            if(Collection::label_subset($combo, $labels)) {
                // relating to the $taboo comment
                if($key >= 4 and $key <= 6) {
                    for ($i=1; $i <= 4; $i++) { 
                        $taboo[] = 3*$i + $key;
                    }
                }
                // relating to the taboo comment
                if(!in_array($key, $taboo)) {
                    $sum += count($combo);
                }
            }
        }

        $this -> value = $sum;
        return $sum;
    }

    // getter
    function value() {
        $res = $this -> value;
        $this -> value = 0;
        return $res;
    }

}

?>