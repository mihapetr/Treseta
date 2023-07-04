<?php 

require_once __DIR__ . "/../../model/table.class.php";

$table = new Table;
$table -> acceptPlayer(new Player("Pero", 0));
$table -> acceptPlayer(new Player("Ivo", 1));
$table -> acceptPlayer(new Player("Ana", 2));
$table -> acceptPlayer(new Player("Marko", 3));
$table -> endPhase();

// player 2 should win the trick
$L1 = [
    new Card(4,"b",1,""),
    new Card(7,"s",1,""),
    new Card(6,"b",3,""),
    new Card(3,"b",1,"")
];

for ($i=0; $i < 4; $i++) { 
    $table -> endPhase();   // skipping calls
    $table -> pool -> play($i, $L1[$i]);
    $table -> endPhase();
}

// player 0 should win the trick
$L2 = [
    new Card(2,"s",1,""),
    new Card(7,"d",1,""),
    new Card(6,"d",3,""),
    new Card(3,"d",1,"")
];

for ($i=0; $i < 4; $i++) { 
    $table -> pool -> play($i, $L2[$i]);
    $table -> endPhase();
}

// check who won
foreach ($table -> players() as $key => $player) {
    echo "<br>" . $player -> name() . ": <br>";
    var_dump($player -> pile() -> cards());
}

// who is to play next
echo "<br>to play: " . $table -> who();

?>