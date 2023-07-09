<?php

require_once __DIR__ . "/collection.class.php";

// a class reprezenting cards won in the round

class Call extends Collection implements JsonSerializable {

    // intitialize an empty collection
    function __construct() {

        parent::__construct();
    }

    // encodes protected values
    public function jsonSerialize() {

        $vars = get_object_vars($this);
        return $vars;
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

    // returns the value of the calling cards
    function evaluate() {

        $cards = $this -> cards;

        $count = count($cards);
        if($count < 3 or $count > 4) return 0;
        // 1,1,1,1 / 2,2,2,2 / 3,3,3,3 ?
        if($count == 4) {
            $label = $cards[0] -> image()[1];
            if(!in_array($label, ["1","2","3"])) return 0;
            foreach ($cards as $key => $card) {
                if($card -> image()[1] != $label) return 0;
            }
            return 4;
        }
        else if($count == 3) {
            if($cards[0]->suit == $cards[1]->suit and $cards[1]->suit == $cards[2]->suit) {
                // 1,2,3 ?
                $labels = [];
                // finish
                for ($i=0; $i < 3; $i++) { 
                    if(isset($cards[$i] -> image()[2])) return 0;
                    $labels[] = $cards[$i] -> image()[1];
                }
                for ($i=1; $i <= 3; $i++) { 
                    if(!in_array($i, $labels)) return 0;
                }
                return 3;
            }
            else {
                // 1,1,1 / 2,2,2 / 3,3,3 ?
                $label = $cards[0] -> image()[1];
                if(!in_array($label, ["1","2","3"])) return 0;
                foreach ($cards as $key => $card) {
                    if($card -> image()[1] != $label) return 0;
                }
                return 3;
            }
        }

    }
}

?>