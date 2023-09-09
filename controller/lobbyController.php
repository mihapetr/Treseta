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

        // empties room if entered an invalid one
        $table = Table::load($_SESSION["roomNumber"]);
        if ($table -> getValid() === false){
            $table = new Table;
            $table -> save($_SESSION["roomNumber"]);
        }

        header ("Location: index.php?rt=gameRoom");
        exit();
    }
};

?>