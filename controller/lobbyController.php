<?php

session_start();

require_once __DIR__ . "/../model/table.class.php";

class lobbyController {
    function index(){
        require_once __DIR__ . "/../view/lobby.php";
    }

    function enterRoom(){
        // adding a player in the n-th room
        // n through POST
        $_SESSION["roomNumber"] = $_POST["roomNumber"];

        header ("Location: index.php?rt=gameRoom");
        exit();
    }
};

?>