<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hand Test</title>
    <style>
        .card {
            border-radius : 10px;
            border : 1px solid black;
            height : 260px;
        }
        .card:hover {
            position : relative;
            bottom : 9vw;
        }
        #hand {
            text-align : center;
            position : absolute;
            bottom : -120px;
            /*border : 1px solid red;*/
            width : 98vw;
        }
        body {
            background-color : lightgreen;
            overflow : hidden;
        }
    </style>
</head>
<body>

<div id="hand">
<?php 

require_once __DIR__ . "/../../model/hand.class.php";
require_once __DIR__ . "/../../model/deck.class.php";

$deck = new Deck;      // creates a new deck and shuffles it
$hand = new Hand;       // creates an empty hand

// deal 10 cards to a hand
for ($i=0; $i < 10; $i++) { 
    $hand -> add($deck -> pop());
    $hand -> sort();
}
$hand -> play(0);
$hand -> play(9);

// retrieve all cards in hand
$in_hand = $hand -> cards();

// display all cards
foreach ($in_hand as $key => $card) {
    $src = "../card_art/" . $card -> img();
    echo sprintf("<img src='%s' class='card'>", $src) ;
}

?>
</div>
</body>
</html>