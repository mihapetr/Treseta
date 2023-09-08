<?php

// for waiting for all 4 players to connect

require_once __DIR__ . "/../model/table.class.php";

while (1){
    $roomNumber = (int) $_SESSION["roomNumber"];
    $table = Table::load($roomNumber);

    if (count($table -> players()) === 4){
        header ("Location: index.php?rt=game");
        exit();
    }

    usleep ( 300000 );
}

?>