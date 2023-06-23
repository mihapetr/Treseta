<?php

require_once __DIR__ . "/player.class.php";
require_once __DIR__ . "/pile.class.php";


class Table {

    protected static $phases;   // describes a full game cycle (every player deals cards)

    protected $phase;       // numerical representation of the phase (a key for $phases)
    protected $players;     // a list of 4 players
    protected $scores;      // turn scores
    protected $pool;        // a list of 0 - 4 cards thrown in current dealing

    public static function getPhases() {

        if(Table::$phases != null) return Table::$phases;

        $ph = [];

        for ($i=0; $i < 4; $i++) { 
            $ph[] = "deal," . $i;
            for ($j=0; $j < 10; $j++) { 
                for ($k=0; $k < 4; $k++) { 
                    $ph[] = "play," . $j . "," . $k;    //play, turn, who
                }
            }
            $ph[] = "count";
        }

        return $ph;
    }

    function __construct() {

        $this -> players = [];
        $this -> scores = [];
        $this -> phase = 0;
    }

    // accepts a player with desired position to the table
    function acceptPlayer($player) {

        if(isset($this -> players[$player -> position])) 
            throw new Exception("Seat taken", 1);
        
        else $this -> players[$player -> position] = $player;

        if(count($this -> players) == 4) {
            // deal cards
        }        
    }

    // returns the current phase
    function phase() {

        return Table::getPhases()[$this -> phase];
    }

    // returns the position of the player to play his card
    function who() {

        $phases = Table::getPhases();
        $info = explode(",", $phases[$this -> phase]);
        if($info[0] == "play") {
            return $info[2];
        }
        else return "none";
    }

    // ends the current phase and takes care of all phases 
    // where there is no playing cards (counting poinsts, dealing)
    function endPhase() {

        $phases = Table::getPhases();
        $this -> phase = $this -> phase == count($phases) - 1 ? 0 : $this -> phase + 1;

        $str = explode(",", $phases[$this -> phase]);

        // deal cards to everyone
        if($str[0] == "deal") {
            
            $this -> deal();
            $this -> endPhase();
        }

        // count points won by each team
        if($str[0] == "count") {

            $this -> count();
            $this -> endPhase();
        }
    }

    private function deal() {

    }

    private function count() {

    }
}