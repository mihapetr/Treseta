<?php

require_once __DIR__ . "/../model/table.class.php";

class waitingRoomController {
    function index(){
        require_once __DIR__ . "/../view/waitingRoom.php";
    }

    function wait(){
        $table = Table::load();

        while (true){
            // all 4 players connected, the game can start
            if ($numberOfPlayers === 4){
                $table -> endPhase();
                $table -> save();
                require_once __DIR__ . "/../view/game.php";
                exit();
            }

            // need to wait
            echo "<br>" . $numberOfPlayers . "/4 players connected";
            usleep(1000000);
        }
    }
}

?>