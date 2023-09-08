<?php

session_start();

require_once __DIR__ . "/../model/table.class.php";

class gameRoomController {
    function index(){
        require_once __DIR__ . "/../view/gameRoom.php";
    }

    function addPlayer(){
        // adding a player in the n-th room
        // n through POST
        $roomNumber = (int) $_SESSION["roomNumber"];
        $_SESSION["position"] = $_POST["position"];
        $username = $_SESSION["username"];

        $table = Table::load($roomNumber);

        if ($table -> getValid() === false) $table = new Table;

        $table -> acceptPlayer(new Player($username, $roomNumber));

        if (count($table -> players()) === 4) $table -> endPhase();
        // last one that joins ends the seating phase

        $table -> save($roomNumber);

        // now that a player is added to a room, he should wait in the gameRoom until all 4 players are added

        require_once __DIR__ . "/../serverCalls/waitForGame.php";
    }
};

?>