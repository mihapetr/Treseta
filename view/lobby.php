<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lobby</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <style>
        .top{
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            font-size: 50px;
            text-align: center;
        }
        body{
            background-color : lightgreen;
            overflow : hidden;
            font-size: 26px;
        }
        .btn{
            background-image: linear-gradient(-180deg, #013220, #320113);
            border-radius: 6px;
            color: white;
            margin-top: 15px;
            height: 48px;
            line-height: 40px;
            text-align: center;
            width: 5%;
            border: 0;
            font-size: 26px;
            margin-right: 25px;
            cursor: pointer;
        }
        .btn_dis{
            background-image: linear-gradient(-180deg, #B2BEB5, #36454F);
            border-radius: 6px;
            color: white;
            margin-top: 15px;
            height: 48px;
            line-height: 40px;
            text-align: center;
            width: 5%;
            border: 0;
            font-size: 26px;
            margin-right: 25px;
        }
        .image{
            position: absolute;
            width: 5%;
            height: auto;
            top: 1%;
            right: 1%;
        }
    </style>
</head>
<body>
    <img src="../images/din.jpg" class="image">
    <div class="top">
        Klikom na gumb odaberite sobu. Pored gumba je naznačeno koliko je igrača trenutno u sobi.
    </div>
    <br><br><br><br><br>
    <div class="mid">
        <form action="index.php?rt=lobby/enterRoom" method="post">
            <button type="submit" name="roomNumber" value="1"
                <?php 
                    $table = Table::load(1);
                    if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                    else echo "class='btn'";
                ?>
            >1.</button>
                <?php
                    $table = Table::load(1);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
            <br>
            <button type="submit" name="roomNumber" value="2" <?php 
                $table = Table::load(2);
                if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                else echo "class='btn'";
                ?>
            >2.</button>
                <?php
                    $table = Table::load(2);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
            <br>
            <button type="submit" name="roomNumber" value="3" <?php 
                $table = Table::load(3);
                if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                else echo "class='btn'";
                ?>
            >3.</button>
                <?php
                    $table = Table::load(3);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
            <br>
            <button type="submit" name="roomNumber" value="4" <?php 
                $table = Table::load(4);
                if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                else echo "class='btn'";
                ?>
            >4.</button>
                <?php
                    $table = Table::load(4);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
            <br>
            <button type="submit" name="roomNumber" value="5" <?php 
                $table = Table::load(5);
                if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                else echo "class='btn'";
                ?>
            >5.</button>
                <?php
                    $table = Table::load(5);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
            <br>
            <button type="submit" name="roomNumber" value="6" <?php 
                $table = Table::load(6);
                if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                else echo "class='btn'";
                ?>
            >6.</button>
                <?php
                    $table = Table::load(6);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
            <br>
            <button type="submit" name="roomNumber" value="7" <?php 
                $table = Table::load(7);
                if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                else echo "class='btn'";
                ?>
            >7.</button>
                <?php
                    $table = Table::load(7);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
            <br>
            <button type="submit" name="roomNumber" value="8" <?php 
                $table = Table::load(8);
                if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                else echo "class='btn'";
                ?>
            >8.</button>
                <?php
                    $table = Table::load(8);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
            <br>
            <button type="submit" name="roomNumber" value="9" <?php 
                $table = Table::load(9);
                if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                else echo "class='btn'";
                ?>
            >9.</button>
                <?php
                    $table = Table::load(9);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
            <br>
            <button type="submit" name="roomNumber" value="10" <?php 
                $table = Table::load(10);
                if (count($table -> players()) === 4 && $table -> getValid() === true) echo "disabled class ='btn_dis'";
                else echo "class='btn'";
                ?>
            >10.</button>
                <?php
                    $table = Table::load(10);
                    if ($table -> getValid() === true) echo count($table -> players());
                    else echo "0";
                ?>
                /4
        </form>
    </div>
</body>
</html>

<?php

?>