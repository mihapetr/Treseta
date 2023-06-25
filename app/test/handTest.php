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
            height : 300px;
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

// retrieve all cards in hand
$in_hand = $hand -> cards();

// display all cards
foreach ($in_hand as $key => $card) {
    $src = "../card_art/" . $card -> img();
    echo sprintf("<div class='box'><img src='%s' class='card'></div>", $src) ;
}

?>
</div>


<script>

$(document).ready(main());

// this has to be called every time a card is thrown
// the last card in hand must not be cut
function lastCard() {
    $(".box:last-child").css("width", "auto");
}

function main() {
    //lastCard();
}

</script>
</body>
</html>