<?php 

require_once __DIR__ . "/../../model/table.class.php";

$table = new Table;
$p1 = new Player("Pero", 0);
$table -> acceptPlayer($p1);
$table -> acceptPlayer(new Player("Ivo", 1));
$table -> acceptPlayer(new Player("Ana", 2));
$table -> acceptPlayer(new Player("Marko", 3));
$table -> endPhase();

$table -> save();

$table = Table::load();
vardump($table -> players());

$table -> save();

?>