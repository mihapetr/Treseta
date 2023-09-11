<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <style>
        .middle{
            position: fixed;
            text-align: center;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        .top{
            position: fixed;
            text-align: center;
            top: 2%;
            left: 50%;
            -webkit-transform: translate(-50%, 0%);
            transform: translate(-50%, 0%);
            font-size: 50px;
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
            width: 90%;
            border: 0;
            font-size: 26px;
            cursor: pointer;
        }
        
        .size{
            width: 90%;
            height: 38px;
            border-radius: 5px;
            border: 0;
        }
        .image{
            width: 30%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="top">
        TREŠETA
        <br><br><br>
        <img src="https://rp2.studenti.math.hr/~dinkmadu/projekt/Treseta/app/card_art/din.jpg" class="image">
    </div>
    
    <div class="middle">
        <form action="index.php?rt=login/analyzeLogin" method="post">
            Dobrodošli na web stranicu za igranje trešete online.
            <br>
            Za nastavak upišite korisničko ime.
            <br>
            Korisničko ime se mora sastojati od 3-20 slova.
            <br><br>
            <input type="text" name="username" class="size">
            <button type="submit" class="btn">Ulogiraj se</button>
        </form>
        <br><br>
        Za pravila igre kliknite <a href="https://igresakartama.com/treseta/">ovdje</a>.
    </div>
    
</body>
</html>