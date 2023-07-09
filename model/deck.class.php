<?php
require_once __DIR__ . "/collection.class.php";
require_once __DIR__ . "/../app/database/db.class.php";


class Deck extends Collection {

    private static $allCards = null;   // all possible cards

    function __construct() {
        $this -> cards = Deck::allCards();   // insert all possible cards into collection
        $this -> shuffle();     // shuffle the deck
    }

    // load all cards from db if not already done
    public static function allCards() {

        if(Deck::$allCards != null) return Deck::$allCards;

        Deck::$allCards = [];

        // fetching all the cards
        $db = DB::getConnection();
        $set = $db -> query("
            select strength, suit, value, image from Card;
        ");
        $set = $set -> fetchAll();

        // iteration and insertion into $allCards
        foreach ($set as $row) {
            Deck::$allCards[] = new Card(
                $row["strength"],
                $row["suit"],
                $row["value"],
                $row["image"]
            );
        }

        return Deck::$allCards;
    }

    // randomize the order of cards in the $cards list
    function shuffle() {
        shuffle($this -> cards);
    }

    // deals the top card and removes it from the deck
    function pop() {
        return array_pop($this -> cards);
    }
}

?>