<?php 

require_once __DIR__ . "/../../model/table.class.php";

$phases = Table::getPhases();

foreach ($phases as $key => $phase) {
    echo $phase . "<br>";
}

?>