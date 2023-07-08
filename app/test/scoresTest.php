<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <title>Hand Test</title>
    <style>
        .box {
            display  : inline-block;
            width : 80px;
            height : 300px;
            overflow : hidden;
        }
        .box:hover {
            width : auto;
            position : relative;
            bottom : 10vw;
        }
        .box:last-child {
            width : auto;
        }
        .card {
            border-radius : 10px;
            border : 1px solid black;
            height : 200px;
        }
        .card:hover {
        }
        #hand {
            text-align : center;
            position : absolute;
            bottom : -140px;
            /*border : 1px solid red;*/
            width : 98vw;
        }
        body {
            background-color : lightgreen;
        }
    </style>
</head>
<body>


<?php 


require_once __DIR__ . "/../../model/table.class.php";

$table = new Table;
$table -> acceptPlayer(new Player("Donatella", 0));
$table -> acceptPlayer(new Player("Samuel", 1));
$table -> acceptPlayer(new Player("Štoki", 2));
$table -> acceptPlayer(new Player("Zoki", 3));
$table -> endPhase();

// all players win their hands (they become their piles)
foreach ($table -> players() as $key => $player) {
    $cards = $player -> hand() -> cards();
    $player -> pile() -> add($cards);

    // display cards for manual counting
    foreach ($cards as $key => $card) {
        $src = "../card_art/" . $card -> img();
        echo sprintf("<div class='box'><img src='%s' class='card'></div>", $src);
    }
    echo "<br>";
}



// testing the count function
$table -> count();

var_dump($table -> scores()); 

$deck = new Deck();

?>

</body>