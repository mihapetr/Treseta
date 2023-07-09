<?php 

// testing akužavanje value function 

require_once __DIR__ . "/../../model/table.class.php";

$combinations = Call::combinations();
foreach ($combinations as $key => $combo) {
    foreach ($combo as $key => $mark) {
        echo $mark . ", ";
    }
    echo "<br>";
}

?>