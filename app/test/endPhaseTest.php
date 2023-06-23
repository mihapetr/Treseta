<?php 

require_once __DIR__ . "/../../model/table.class.php";

$table = new Table;

for ($i=0; $i < 300; $i++) { 
    echo $table -> phase() . ", ";
    echo "player: " . $table -> who() . "<br>";
    $table -> endPhase();
}

?>