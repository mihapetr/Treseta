<?php

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

        $table -> acceptPlayer($username, $roomNumber);

        $table -> save($roomNumber);

        // now that a player is added to a room, he should wait in the gameRoom until all 4 players are added

        require_once __DIR__ . "/../serverCalls/waitForGame.php";
        exit();
    }
};

?>