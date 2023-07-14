<?php

require_once __DIR__ . "/../model/table.class.php";

class waitingRoomController {
    function index(){
        require_once __DIR__ . "/../view/waitingRoom.php";
    }

    function wait(){
        while (true){
            // doesnt work?!
            // phase is 1 and it doesnt leave
            $table = Table::load();

            // all 4 players connected, the game can start
            if ($table -> phase() != -1)
            {
                // last player to connect ended the seating phase so just connect
                header( "Location: index.php?rt=game" );
                exit();
            }
            // wait 1s and try again
            usleep(2000000);
        }
    }
};

?>