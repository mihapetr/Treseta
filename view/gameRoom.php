<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game room</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
</head>
<body>
    Choose a position
    <form action="index.php?rt=gameRoom/addPlayer" method="post">
    <button type="submit" name="position" value="0" <?php
        $roomNumber = $_SESSION["roomNumber"];
        $table = Table::load($roomNumber);
        foreach ($table -> players() as $player){
            if ($player -> position() == 0) echo "disabled";
        }
    ?>
    >1.</button>
    <br>
    <button type="submit" name="position" value="1" <?php
        $roomNumber = $_SESSION["roomNumber"];
        $table = Table::load($roomNumber);
        foreach ($table -> players() as $player){
            if ($player -> position() == 1) echo "disabled";
        }
    ?>
    >2.</button>
    <br>
    <button type="submit" name="position" value="2" <?php
        $roomNumber = $_SESSION["roomNumber"];
        $table = Table::load($roomNumber);
        foreach ($table -> players() as $player){
            if ($player -> position() == 2) echo "disabled";
        }
    ?>
    >3.</button>
    <br>
    <button type="submit" name="position" value="3" <?php
        $roomNumber = $_SESSION["roomNumber"];
        $table = Table::load($roomNumber);
        foreach ($table -> players() as $player){
            if ($player -> position() == 3) echo "disabled";
        }
    ?>
    >4.</button>
    </form>
</body>
</html>