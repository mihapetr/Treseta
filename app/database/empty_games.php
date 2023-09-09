<?php

require_once __DIR__ . "/../../model/table.class.php";

// only used once to fill the table
// don't run this

$db = DB::getConnection();

for ($i = 1; $i <= 10; $i++){
    $db = DB::getConnection();

    $table = new Table;

    $st = $db -> prepare("
        insert into State (id, who, object) values (:id, :who, :object);
    ");

    $st -> execute(array(
        "id" => $i,
        "who" => -1,
        "object" => json_encode($table)
    ));

}

?>