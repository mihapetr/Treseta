<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game room</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <style>
        .top{
            position: absolute;
            padding-top: 50px;
            top: 30%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            font-size: 40px;
            text-align: center;
        }
        .top_left{
            position: relative;
            text-align: left;
        }
        body 
        {
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
            width: 8rem;
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
            width: 8rem;
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
    <div id="position" style="display : none;"><?php echo (int) $_SESSION["position"]; ?></div>
    <img src="https://rp2.studenti.math.hr/~dinkmadu/projekt/Treseta/app/card_art/din.jpg" class="image">
    <div class="top">
        <br><br>
        Nalazite se u sobi broj <?php echo $_SESSION["roomNumber"]; ?>.
        <br><br>
        Odaberite poziciju u kojoj želite igrati.
        Prvu igru miješa prvi igrač, to jest drugi igrač igra prvu kartu u prvoj ruci. Sljedeću igru miješa drugi igrač.
        <br><br>
        Ako je pozicija zauzeta, pored gumba piše korisničko ime igrača koji je na toj poziciji.
        <br><br><br>
        <div class="top_left">
            <form action="index.php?rt=gameRoom/addPlayer" method="post">
            <button type="submit" name="position" value="0" <?php
                $roomNumber = $_SESSION["roomNumber"];
                $table = Table::load($roomNumber);
                $dis=0;
                foreach ($table -> players() as $player){
                    if ($player -> position() == 0){
                        echo "disabled class='btn_dis'";
                        $dis=1;
                    }
                }
                if ($dis === 0) echo "class='btn'"; 
            ?>
            >1.</button>
            <?php
                $roomNumber = $_SESSION["roomNumber"];
                foreach ($table -> players() as $player){
                    if ($player -> position() == 0) echo $player -> name();
                }
            ?>
            <br>
            <button type="submit" name="position" value="1" <?php
                $roomNumber = $_SESSION["roomNumber"];
                $table = Table::load($roomNumber);
                $dis=0;
                foreach ($table -> players() as $player){
                    if ($player -> position() == 1){
                        echo "disabled class='btn_dis'";
                        $dis=1;
                    }
                }
                if ($dis === 0) echo "class='btn'"; 
            ?>
            >2.</button>
            <?php
                $roomNumber = $_SESSION["roomNumber"];
                foreach ($table -> players() as $player){
                    if ($player -> position() == 1) echo $player -> name();
                }
            ?>
            <br>
            <button type="submit" name="position" value="2" <?php
                $roomNumber = $_SESSION["roomNumber"];
                $table = Table::load($roomNumber);
                $dis=0;
                foreach ($table -> players() as $player){
                    if ($player -> position() == 02){
                        echo "disabled class='btn_dis'";
                        $dis=1;
                    }
                }
                if ($dis === 0) echo "class='btn'"; 
            ?>
            >3.</button>
            <?php
                $roomNumber = $_SESSION["roomNumber"];
                foreach ($table -> players() as $player){
                    if ($player -> position() == 2) echo $player -> name();
                }
            ?>
            <br>
            <button type="submit" name="position" value="3" <?php
                $roomNumber = $_SESSION["roomNumber"];
                $table = Table::load($roomNumber);
                $dis=0;
                foreach ($table -> players() as $player){
                    if ($player -> position() == 3){
                        echo "disabled class='btn_dis'";
                        $dis=1;
                    }
                }
                if ($dis === 0) echo "class='btn'"; 
            ?>
            >4.</button>
            <?php
                $roomNumber = $_SESSION["roomNumber"];
                foreach ($table -> players() as $player){
                    if ($player -> position() == 3) echo $player -> name();
                }
            ?>
            </form>
        </div>
        <br><br>
        Nakon što ste odabrali poziciju, pričekajte da se sva mjesta popune.
        <br><br>
        Nakon što uđete u igru i kada dođete na potez, prvo se nalazite u fazi akužavanja.
        Kada odaberete karte i kliknete na gumb "Akužaj" ili samo kliknete na gumb (ako nemate ništa),
        dolazite u fazu igranja. Tada birate kartu koju želite igrati uz poštivanje pravila te,
        nakon što ste odigrali kartu, čekate na svoj potez.
    </div>
</body>
</html>