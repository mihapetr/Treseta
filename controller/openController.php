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
};

class OpenController {

    // initializes the Table object and saves it to DB
    function index() {

        $table = new Table;
        $table -> setValid(false);
        // this part should be done by each client when they 
        // enter their name and position
        $table -> acceptPlayer(new Player("Alice", 0));
        $table -> acceptPlayer(new Player("Bob", 1));
        $table -> acceptPlayer(new Player("Eve", 2));
        $table -> acceptPlayer(new Player("David", 3));
        // seating phase has ended
        $table -> endPhase();
        // save the game state
        $table -> save(1);

        $msg = sprintf("started game, phase: %s, player: %s", $table -> phase(), $table -> who());
        echo json_encode(new Message(null, $msg));
    }

    // returns card images each player has in their hand
    function getHands() {

        $table = Table::load(1);
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

        $table = Table::load(1);
        $player = $_POST["played"][0];  // first char in card box id
        $card = $_POST["played"][1];    // second char in card box id

        // create objects
        $physicalCard = $table -> players()[$player] -> hand() -> card($card);
        $physicalPlayer = $table -> players()[$player];

        // player is adding or removing cards from the call
        if(explode(",", $table -> phase())[0] == "call") {
            $deed = $physicalPlayer -> call() -> add_or_remove($physicalCard);
            // $deed is "removed" or "added" 
            $table -> save(1);   
            echo json_encode(new Message($deed[1], $deed[0]));
            exit(0);
        }

        // is it a legal play?
        if(! $table -> pool -> isLegal($physicalPlayer, $physicalCard)) {
            echo json_encode(new Message(null, "illegal"));
            exit(1);      
        }

        $table -> played($player, $card);
        $table -> endPhase();
        $table -> save(1);
        $msg = $player . $card;
        if($table -> pool -> isEmpty()) {
            $msg .= "c";    // collect the pool on the client
            $msg .= $table -> pool -> lastWinner();    // who won the trick
            if(explode(",", $table -> phase())[0] == "call") $msg .= "s";    // client updates scores
        }
        $log = sprintf("phase: %s, player: %s", $table -> phase(), $table -> who());
        echo json_encode(new Message($log, $msg));
    }

    // akužavanje
    function call() {

        $table = Table::load(1);
        // show cards to other players

        if(explode(",", $table -> phase())[0] != "call") {
            $msg = "wrong_action";
            echo json_encode(new Message(null, $msg));
            exit(1);
        }

        $player = $_POST["player"];

        $val = $table -> players()[$player] -> call() -> evaluate();   // Call::$value now has value

        $table -> endPhase();
        $table -> save(1);
        $msg = "called";
        echo json_encode(new Message($val, $msg));
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
                /*$table = Table::load();
                // if a player needs a new hand
                $msg = "";
                if(explode(",", $table -> phase())[0] == "call") {
                    $msg = "new_hand";
                }*/
                echo json_encode(new Message(null, null));
                break;
            }
            usleep(100000);
        }
    }

    function getScores() {

        $table = Table::load(1);
        echo json_encode($table -> scores());
    }

    function invalidate(){
        $table = Table::load(1);
        $table -> setValid(false);
        $table -> save(1);
        session_unset();
        session_destroy();
    }
};

?>