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
        $table -> played($player, $card);
        $table -> endPhase();
        $table -> save();
        $msg = sprintf("phase: %s, player: %s", $table -> phase(), $table -> who());
        echo json_encode(new Message($table -> pool, $msg));
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
}

?>