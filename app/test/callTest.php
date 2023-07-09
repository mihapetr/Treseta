<?php 

// testing akužavanje value function 

require_once __DIR__ . "/../../model/table.class.php";

$cardSets = [];

// expected value is 3
$cardSets[] = [
    new Card("","c","","c1"),
    new Card("","c","","c3"),
    new Card("","c","","c2")
];

// expected value is 3
$cardSets[] = [
    new Card("","b","","b1"),
    new Card("","b","","b3"),
    new Card("","b","","b2")
];

// expected value is 4
$cardSets[] = [
    new Card("","b","","b1"),
    new Card("","c","","c1"),
    new Card("","d","","d1"),
    new Card("","s","","s1")
];

// expected value is 4
$cardSets[] = [
    new Card("","s","","s2"),
    new Card("","d","","d2"),
    new Card("","c","","c2"),
    new Card("","b","","b2")
];

// expected value is 0
$cardSets[] = [
    new Card("","s","","s3"),
    new Card("","d","","d3"),
    new Card("","c","","c3"),
    new Card("","b","","b2")
];

// expected value is 3
$cardSets[] = [
    new Card("","c","","c1"),
    new Card("","d","","d1"),
    new Card("","s","","s1")
];

// expected value is 0
$cardSets[] = [
    new Card("","c","","c7"),
    new Card("","d","","d7"),
    new Card("","s","","s7")
];

$cardSets[] = [];

echo "expected: 33440300 <hr>";
foreach ($cardSets as $key => $cards) {
    $call = new Call();
    $call -> setCards($cards);
    echo "value: " . $call -> evaluate() . "<br>";
}

?>