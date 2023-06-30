<?php

require_once __DIR__ . "/../model/table.class.php";

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

        echo "started";
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
}

?>