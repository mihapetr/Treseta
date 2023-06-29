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

    // REVIEW
    // returns the value of the calling cards
    public static function call($cards) {

        $count = count($cards);
        if($count < 3 or $count > 4) return 0;
        // 1,1,1,1 / 2,2,2,2 / 3,3,3,3 ?
        if($count == 4) {
            $label = $cards[0] -> image[1];
            if(!in_array($label, ["1","2","3"])) return 0;
            foreach ($cards as $key => $card) {
                if($card -> image[1] != $label) return 0;
            }
            return 4;
        }
        else if($count == 3) {
            if($cards[0]->suit == $cards[1]->suit and $cards[1]->suit == $cards[2]->suit) {
                // 1,2,3 ?
                usort($cards, [Card::class, "cmp"]);
                if(
                    $cards[0]->image[1] != "1" or
                    $cards[1]->image[1] != "2" or
                    $cards[2]->image[1] != "3"
                ) return 0;
                else return 3;
            }
            else {
                // 1,1,1 / 2,2,2 / 3,3,3 ?
                $label = $cards[0] -> image[1];
                if(!in_array($label, ["1","2","3"])) return 0;
                foreach ($cards as $key => $card) {
                    if($card -> image[1] != $label) return 0;
                }
                return 3;
            }
        }

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