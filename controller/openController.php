<?php

require_once __DIR__ . "/../model/table.class.php";

// sending messages to the client (debugging)
class Message {
    
    public $object;
    public $msg;
    function __construct($o, $m) {
        $this -> object = $o;
        $this -> msg = $m;
    }
}

class OpenController {

    // initializes the Table object and saves it to DB
    function index() {

        $table = new Table;
        // this part should be done by each client when they 
        // enter their name and position
        $table -> acceptPlayer(new Player("Alice", 0));
        $table -> acceptPlayer(new Player("Bob", 1));
        $table -> acceptPlayer(new Player("Eve", 2));
        $table -> acceptPlayer(new Player("David", 3));
        // seating phase has ended
        $table -> endPhase();
        // save the game state
        $table -> save();

        $msg = sprintf("started game, phase: %s, player: %s", $table -> phase(), $table -> who());
        echo json_encode(new Message(null, $msg));
    }

    // returns card images each player has in their hand
    function getHands() {

        $table = Table::load();
        $hands = [];
        foreach ($table -> players() as $key => $player) {
            $images = [];
            foreach ($player -> hand() -> cards() as $key => $card) {
                $images[] = $card -> img();
            }
            $hands[] = $images;
        }

        echo json_encode($hands);
    }

    // when a player plays a card
    function play() {

        $table = Table::load();
        $player = $_POST["played"][0];  // first char in card box id
        $card = $_POST["played"][1];    // second char in card box id

        // check if it is a legal move
        $physicalCard = $table -> players()[$player] -> hand() -> card($card);
        $physicalPlayer = $table -> players()[$player];
        if(! $table -> pool -> isLegal($physicalPlayer, $physicalCard)) {
            echo json_encode(new Message(null, "illegal"));
            exit(1);      
        }

        $table -> played($player, $card);
        $table -> endPhase();
        $table -> save();
        $msg = $player . $card;
        if($table -> pool -> isEmpty()) {
            $msg .= "c";    // collect the pool on the client
            $msg .= $table -> who();    // who won the trick
            if($table -> phase()[1] == "0") $msg .= "s";    // client updates scores
        }
        $log = sprintf("phase: %s, player: %s", $table -> phase(), $table -> who());
        echo json_encode(new Message($log, $msg));
    }

    // akužavanje
    function call() {

        $table = Table::load();
        // todo
        $table -> endPhase();
        $table -> save();
        $msg = sprintf("phase: %s, player: %s", $table -> phase(), $table -> who());
        echo json_encode(new Message($table -> pool, $msg));
    }

    // long polling loop
    function await() {

        $db = DB::getConnection();
        $player = $_POST["player"];

        while(true) {
            $res = $db -> query("
                select who from State where id = 1;
            ");
            $who = $res -> fetchAll()[0]["who"];

            // request matches the database state
            if($player == $who) {
                echo json_encode(new Message(null, null));
                break;
            }
            usleep(100000);
        }
    }

    function getScores() {

        $table = Table::load();
        echo json_encode($table -> scores());
    }
}

?>