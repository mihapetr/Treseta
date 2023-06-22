<?php

require_once __DIR__ . "/db.class.php";

$db = DB::getConnection();

$suits = ["b","c","d","s"];
$nums = [4,5,6,7,11,12,13,1,2,3]; // ordered by strength ascending
$vals = [0,0,0,0, 1, 1, 1,3,1,1]; // corresponding bela points


try {
    $st = $db -> prepare(
        "insert into Card(strength, suit, value, image) values(
            :str, :suit, :val, :img
        );"
    );

    foreach ($suits as $key => $suit) {
        foreach ($nums as $strength => $label) {
            $st -> execute(array(
                "str" => $strength,
                "suit" => $suit,
                "val" => $vals[$strength],
                "img" => $suit . $label     // dropping the .jpg extension
            ));
        }
    }
} catch (PDOException $e) {
    echo "Error when filling cards: " . $e -> getMessage();
    exit();
}


?>