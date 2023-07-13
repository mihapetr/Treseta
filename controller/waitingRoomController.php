<?php

require_once __DIR__ . "/../model/table.class.php";

class waitingRoomController {
    function index(){
        require_once __DIR__ . "/../view/waitingRoom.php";
    }

    function wait(){
        while (true){
            $table = Table::load();
            $numberOfPlayers = count($table -> players());
            // all 4 players connected, the game can start

            // someone already ended the phase, just move the view to game.php
            if ($table -> phase() !== -1){
                header( "Location: index.php?rt=game" );
            }
            // all 4 players connected, the game can start
            if ($numberOfPlayers === 4){
                $table -> endPhase();
                $table -> save();
                header( "Location: index.php?rt=game" );
            }

            // need to wait
            usleep(1000000);
        }
    }
};

?>