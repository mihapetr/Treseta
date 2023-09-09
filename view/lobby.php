<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lobby</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
</head>
<body>
    Choose a room ... (should disable full rooms, also add a player counter next to the button)
    <br>
    <form action="index.php?rt=lobby/enterRoom" method="post">
        <button type="submit" name="roomNumber" value="1" <?php 
            $table = Table::load(1);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >1.</button>
        <br>
        <button type="submit" name="roomNumber" value="2" <?php 
            $table = Table::load(2);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >2.</button>
        <br>
        <button type="submit" name="roomNumber" value="3" <?php 
            $table = Table::load(3);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >3.</button>
        <br>
        <button type="submit" name="roomNumber" value="4" <?php 
            $table = Table::load(4);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >4.</button>
        <br>
        <button type="submit" name="roomNumber" value="5" <?php 
            $table = Table::load(5);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >5.</button>
        <br>
        <button type="submit" name="roomNumber" value="6" <?php 
            $table = Table::load(6);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >6.</button>
        <br>
        <button type="submit" name="roomNumber" value="7" <?php 
            $table = Table::load(7);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >7.</button>
        <br>
        <button type="submit" name="roomNumber" value="8" <?php 
            $table = Table::load(8);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >8.</button>
        <br>
        <button type="submit" name="roomNumber" value="9" <?php 
            $table = Table::load(9);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >9.</button>
        <br>
        <button type="submit" name="roomNumber" value="10" <?php 
            $table = Table::load(10);
            if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled";
            ?>
        >10.</button>
    </form>
</body>
</html>

<?php

?>