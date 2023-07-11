<?php

require_once __DIR__ . "/player.class.php";
require_once __DIR__ . "/pile.class.php";
require_once __DIR__ . "/deck.class.php";
require_once __DIR__ . "/pool.class.php";
require_once __DIR__ . "/../app/database/db.class.php";
require_once __DIR__ . "/decoder.php";


class Table implements JsonSerializable {

    protected static $phases;   // describes a full game cycle (every player deals cards)

    protected $phase;       // numerical representation of the phase (a key for $phases)
    protected $players;     // a list of 4 players
    protected $scores;      // turn scores, list
    public $pool;        // a Pool object   
    protected $who;         // whose turn it is to play 
    protected $valid;       // tracks if a player leaves the game

    public static function getPhases() {

        if(Table::$phases != null) return Table::$phases;

        $ph = [];

        for ($i=0; $i < 4; $i++) { 
            $ph[] = "deal," . $i;
            for ($j=0; $j < 10; $j++) { 
                for ($k=0; $k < 4; $k++) { 
                    if($j == 0) $ph[] = "call," . $k;     // akužavanje
                    $ph[] = "play," . $j . "," . $k;    // play, trick, card
                }
                $ph[] = "collect";
            }
            $ph[] = "count";
        }

        return $ph;
    }

    function __construct() {

        $this -> players = [];
        $this -> scores = [];
        $this -> pool = new Pool();
        $this -> valid = false;
        $this -> phase = -1;    // represents the seating phase
        // if a phase is ended after all players are seated, cards will be dealt
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

    // accepts a player with desired position to the table
    function acceptPlayer($player) {

        if(isset($this -> players[$player -> position()])) 
            throw new Exception("Seat taken", 1);
        
        else $this -> players[$player -> position()] = $player;     
    }

    // getter for players
    function players() {
        return $this -> players;
    }

    function set_player($player) {
        
        $this -> players[] = $player;
    }

    // setter and getter for valid
    function getValid(){
        return $this -> valid; 
    }

    function setValid($bool){
        $this -> valid = $bool;
    }

    // returns the current phase
    function phase() {

        return Table::getPhases()[$this -> phase];
    }

    // returns the position of the player to play his card
    function who() {

        return $this -> who;
    }

    // playing a card
    function played($who, $which) {

        $player = $this -> players[$who];
        $card = $player -> play($which);
        $this -> pool -> play($who, $card);
    }

    // ends the current phase and takes care of all phases 
    // where there is no playing cards (counting poinsts, dealing)
    function endPhase() {

        $phases = Table::getPhases();
        $this -> phase = $this -> phase == count($phases) - 1 ? 0 : $this -> phase + 1;

        $str = explode(",", $phases[$this -> phase]);

        // only the first player who calls is not after someone
        if($str[0] == "call" and $str[1] != 0) {

            $this -> who = ($this -> who + 1) % 4;
            return;
        }

        if($str[0] == "play" and $str[1] == 0) {

            // nothing, the player is already on turn (calling in the first trick)
            return;
        }

        // in the middle of the trick
        if($str[0] == "play" and $str[2] != 0) {

            $this -> who = ($this -> who + 1) % 4;
        }

        // deal cards to everyone
        if($str[0] == "deal") {
            
            $this -> deal($str[1]);
            $this -> who = (intval($str[1]) + 1) % 4;   // player to the "left"
            $this -> endPhase();
        }

        // collect the trick
        if($str[0] == "collect") {

            $winner = $this -> pool -> winner();
            $this -> players[$winner] -> pile() -> add($this -> pool -> collect());
            $this -> who = $winner;
            $this -> endPhase();
        }

        // count points won by each team
        if($str[0] == "count") {

            $this -> count();
            $this -> endPhase();
        }
    }

    // deal everyone cards
    private function deal($dealer) {

        if(count($this -> players) != 4) throw new Exception("Not enough players", 1);
        
        $deck = new Deck;
        $target = ($dealer + 1) % 4;

        // empty everone's hand
        foreach ($this -> players as $key => $player) {
            $player -> hand() -> empty();
        }

        while(! $deck -> isEmpty()) {
            for ($i=0; $i < 5; $i++) { 
                // deal a card to the target player
                $this -> players[$target] -> take($deck -> pop());
            }
            $this -> players[$target] -> hand() -> sort();
            $target = ($target + 1) % 4;
        }

    }

    // save the score
    // evens : p0, p2
    // odds : p1, p3
    function count() {

        $evens = 0;
        $odds = 0;

        $evens += $this -> players[0] -> pile() -> count();
        $evens += $this -> players[2] -> pile() -> count();
        $odds += $this -> players[1] -> pile() -> count();
        $odds += $this -> players[3] -> pile() -> count();

        $evens = intdiv($evens, 3);
        $odds = intdiv($odds, 3);

        // lastWinner() holds info about the winner of the last trick
        if($this -> pool -> lastWinner() % 2 == 0) $evens += 1;
        else $odds += 1;

        // add bonus points from calls
        foreach ($this -> players as $key => $player) {
            if($key%2 == 0) {
                $evens += $player -> call() -> value();
            }
            if($key%2 == 1) {
                $odds += $player -> call() -> value();
            }
        }

        $this -> scores[] = [$evens, $odds];
    }

    // getter
    function scores() {

        return $this -> scores;
    }

    // saves the Table object to the database;
    // for now there is only one row with id = 1
    function save() {

        $db = DB::getConnection();

        // firstly who table atribute has to be set to -1 to prevent the server
        // from triggering the long polling condition from the same client;
        // encoding and saving objects takes more time than tinyint
        $db -> query("
            update State
            set who = -1
            where id = 1;
        ");
        // now noone's request for playing turn can be handled because
        // "who" in db has to match client position

        $st = $db -> prepare("
            update State
            set who = :who, object = :object
            where id = 1;
        ");

        $st -> execute(array(
            "who" => $this -> who(),
            "object" => json_encode($this)
        ));

        ///////////// DEBUG //////////////
        // echo json_encode($this);
        /////////////////////////////////
    }

    // load object from database
    public static function load() {

        $db = DB::getConnection();

        $res = $db -> query("
            select object from State where id = 1;
        ");

        $json = $res -> fetchAll()[0]["object"];
        
        // use loadJSON
        $table = loadJson((new Table), $json);

        return $table;
    }
}