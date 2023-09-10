<?php

session_start();

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
        $position = (int) $_POST["position"];
        $roomNumber = (int) $_POST["roomNumber"];
        $table = Table::load($roomNumber);
        $hand = [];
        // $player = $table -> players()[$position]; // gets the Player from the table
        foreach ($table -> players() as $key => $player){
            if ($player -> position() == $position){
                foreach ($player -> hand() -> cards() as $key => $card){
                    $hand[] = $card -> img();
                }
            }
        }
        
        echo json_encode($hand);
    }

    function play(){
        $roomNumber =(int) $_POST["roomNumber"];
        $table = Table::load($roomNumber);
        $player =(int) $_POST["position"];
        $card = $_POST["played"];

        // create objects
        $physicalCard = $table -> players()[$player] -> hand() -> card($card);
        $physicalPlayer = $table -> players()[$player];

        // player is adding or removing cards from the call
        if(explode(",", $table -> phase())[0] == "call") {
            $deed = $physicalPlayer -> call() -> add_or_remove($physicalCard);
            // $deed[0] is "removed" or "added" 
            $table -> save($roomNumber);   
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
        $table -> save($roomNumber);
        $msg = $player . $card;
        if($table -> pool -> isEmpty()) {
            $msg .= "c";    // collect the pool on the client
            $msg .= $table -> pool -> lastWinner();    // who won the trick
            if(explode(",", $table -> phase())[0] == "call") $msg .= "s";    // client updates scores
        }
        $log = sprintf("phase: %s, player: %s", $table -> phase(), $table -> who());
        echo json_encode(new Message($log, $msg));
    }

    function call(){
        $roomNumber = (int) $_POST["roomNumber"];
        $position = (int) $_POST["position"];
        $table = Table::load($roomNumber);

        if(explode(",", $table -> phase())[0] != "call") {
            $msg = "wrong_action";
            echo json_encode(new Message(null, $msg));
            exit(1);
        }

        $val = $table -> players()[$position] -> call() -> evaluate();   // Call::$value now has value
        $table -> endPhase();
        $table -> save($roomNumber);
        $msg = "called";
        echo json_encode(new Message($val, $msg));
    }

    function await(){
        $db = DB::getConnection();
        $player = $_POST["position"];
        $roomNumber = $_POST["roomNumber"];

        while(true) {
            if (isset($who)) $whoPrev = $who;
            else $whoPrev = null;
            $res = $db -> prepare("
                select who from State where id = :id;
            ");

            $res -> execute (array(
                "id" => $roomNumber
            ));

            $who = $res -> fetchAll()[0]["who"];

            // request matches the database state
            if($player == $who) {
                echo json_encode(new Message(null, null));
                break;
            }
            usleep(100000);
        }
    }

    function returnPolls(){
        $roomNumber =(int) $_POST["roomNumber"];
        $position =(int) $_POST["position"];
        $table = Table::load($roomNumber);
        echo json_encode($table -> pool);
    }

    function updatePool(){
        $roomNumber =(int) $_POST["roomNumber"];
        $table = Table::load($roomNumber);
        $table -> updatedPool = [true, true, true, true];

        $table -> save($roomNumber);
    }

    function getScores(){
        $table = Table::load((int) $_POST ["roomNumber"]);
        $val = $table -> scores();
        echo json_encode($val);
    }

    function invalidate(){
        $roomNumber =(int) $_POST["roomNumber"];
        $table = Table::load($roomNumber);
        $table -> setValid(false);
        $table -> save($roomNumber);
        session_unset();
        session_destroy();
        exit(0);
    }
};

?>