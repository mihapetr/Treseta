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
    echo sprintf("<img src='%s' height='260'>", $src) ;
}



?>