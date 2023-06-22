<?php 

require_once __DIR__ . "/../../model/deck.class.php";

$deck = new Deck;      // creates a new deck and shuffles it

// print all cards' details
for ($i=0; $i < 40; $i++) { 
    $card = $deck -> pop();
    echo $card . "<br>";
}

$deck = new Deck;

// print all cards' details
for ($i=0; $i < 40; $i++) { 
    $card = $deck -> pop();
    $src = "../card_art/" . $card -> img();
    echo sprintf("<img src='%s' height='300'>", $src) ;
}



?>