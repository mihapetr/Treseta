<?php

require_once __DIR__ . "/player.class.php";
require_once __DIR__ . "/pile.class.php";


class Table {

    protected static $phases;   // describes a full game cycle (every player deals cards)

    protected $phase;
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
        $this -> phases = Table::getPhases();
    }

    // accepts a player with desired position to the table
    function accept($player) {

        if(isset($this -> players[$player -> position])) 
            throw new Exception("Seat taken", 1);
        
        else $this -> players[$player -> position] = $player;
        
    }

    function end($phase) {

    }

}