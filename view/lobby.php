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
            $table = Table::load($_SESSION["roomNumber"]);
            if (count($table -> players()) === 4 && )
        ?>>1.</button>
        <br>
        <button type="submit" name="roomNumber" value="2">2.</button>
        <br>
        <button type="submit" name="roomNumber" value="3">3.</button>
        <br>
        <button type="submit" name="roomNumber" value="4">4.</button>
        <br>
        <button type="submit" name="roomNumber" value="5">5.</button>
        <br>
        <button type="submit" name="roomNumber" value="6">6.</button>
        <br>
        <button type="submit" name="roomNumber" value="7">7.</button>
        <br>
        <button type="submit" name="roomNumber" value="8">8.</button>
        <br>
        <button type="submit" name="roomNumber" value="9">9.</button>
        <br>
        <button type="submit" name="roomNumber" value="10">10.</button>
    </form>
</body>
</html>

<?php

?>