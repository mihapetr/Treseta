<?php

require_once __DIR__ . "/../model/table.class.php";

// sending messages to the client
class Message {
    public $object;
    public $msg;
    function __construct($o, $m) {
        $this -> object = $o;
        $this -> msg = $m;
    }
};

class gameController {

    
    function index() {
        require_once __DIR__ . "/../view/game.php";
    }

    function getHand(){
        $position = (int) $_SESSION["position"];
        $table = Table::load();
        $hand = [];
        $player = $table -> players()[$position]; // gets the Player from the table
        foreach ($player -> hand() -> cards() as $key => $card){
            $hand[] = $card -> img();
        }
        echo json_encode($hand);

    }

    function play(){
        $table = Table::load();
        $player = $_SESSION["username"];
        $card = $_POST["played"];

        // create objects
        $physicalCard = $table -> players()[$player] -> hand() -> card($card);
        $physicalPlayer = $table -> players()[$player];

        // player is adding or removing cards from the call
        if(explode(",", $table -> phase())[0] == "call") {
            $deed = $physicalPlayer -> call() -> add_or_remove($physicalCard);
            // $deed is "removed" or "added" 
            $table -> save();   
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
        $table -> save();
        $msg = $card;
        if($table -> pool -> isEmpty()) {
            $msg .= "c";    // collect the pool on the client
            $msg .= $table -> pool -> lastWinner();    // who won the trick
            if(explode(",", $table -> phase())[0] == "call") $msg .= "s";    // client updates scores
        }
        $log = sprintf("phase: %s, player: %s", $table -> phase(), $table -> who());
        echo json_encode(new Message($log, $msg));
    }

    function call(){
        $table = Table::load();
        // show cards to other players

        if(explode(",", $table -> phase())[0] != "call") {
            $msg = "wrong_action";
            echo json_encode(new Message(null, $msg));
            exit(1);
        }

        $player = $_SESSION["username"];

        $val = $table -> players()[$player] -> call() -> evaluate();   // Call::$value now has value
        $table -> endPhase();
        $table -> save();
        $msg = "called";
        echo json_encode(new Message($val, $msg));
    }

    function await(){
        $db = DB::getConnection();
        $player = $_SESSION["username"];

        while(true) {
            if (isset($who)) $whoPrev = $who;
            else $whoPrev = null;
            $res = $db -> query("
                select who from State where id = 1;
            ");
            $who = $res -> fetchAll()[0]["who"];

            // check if someone else made the move
            if ($whoPrev != null && $who != $whoPrev){
                
            }
            // request matches the database state
            if($player == $who) {
                echo json_encode(new Message(null, null));
                break;
            }
            usleep(100000);
        }
    }

    function getScores(){
        $table = Table::load();
        echo json_encode($table -> scores());
    }

    function invalidate(){
        $table = Table::load();
        $table -> setValid(false);
        $table -> save();
        session_unset();
        session_destroy();
    }
};

?>