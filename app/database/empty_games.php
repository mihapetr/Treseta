<?php

require_once __DIR__ . "/../../model/table.class.php";

// only used once to fill the table
// don't run this

$db = DB::getConnection();

for ($i = 1; $i <= 10; $i++){
    $db = DB::getConnection();

    $res = $db -> prepare("
            select id from State where id = :id;
    ");

    $res -> execute(array(
        "id" => $i
    ));

    $return = $res -> fetch()[0];

    
    $table = new Table;

    if (1){
        $st = $db -> prepare("
            insert into State (id, who, object) values (:id, :who, :object);
        ");

        $st -> execute(array(
            "id" => $i,
            "who" => -1,
            "object" => json_encode($table)
        ));
    }
    
    else {
        $table -> save($i);
    }
}

?>