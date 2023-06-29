<?php

require_once __DIR__ . "/../model/table.class.php";

class OpenController {

    // initializes the Table object and saves it to DB
    function start() {

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

    // returns html representation of cards each player has in their hand
    function getHands() {

        $table = Table::load();
        $hands = [];
        $src = null;
        foreach ($table -> players() as $key => $player) {
            $hand = $player -> hand() -> cards();
            $str = "";
            foreach ($hand as $key => $card) {
                $src = "../app/card_art/" . $card -> img();     // prilagoditi za index
                $str .= sprintf(
                    "<div class='box'>
                        <img src='%s' class='card'>
                    </div>"
                , $src);
            }
            $hands[] = $str;
        }

        echo json_encode($hands);
    }
}

?>