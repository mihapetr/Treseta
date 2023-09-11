<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trešeta</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <style>
        .box {
            display  : inline-block;
            height : 200px;
            overflow : hidden;
        }
        .box:hover {
            width : auto;
            position : relative;
            bottom : 10vw;
        }
        .box:last-child {
            width : auto;
        }
        .playing_field{
            position : fixed;
            bottom: 0;
            right: 0;
            left: 0;
            top: 0;
        }
        .call{
            position : absolute;
            right : 18%;
            bottom : 20px;
            background-image: linear-gradient(-180deg, #013220, #320113);
            border-radius: 6px;
            color: white;
            margin-top: 15px;
            height: 100px;
            line-height: 40px;
            text-align: center;
            width: 5%;
            border: 0;
            font-size: 26px;
            margin-right: 25px;
            cursor: pointer;
        }
        .card {
            border-radius : 10px;
            border : 1px solid black;
            height : 200px;
        }
        .score{
            position : absolute;
            right : 0;
        }
        table.center{
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%);
            /* background-image: url("https://rp2.studenti.math.hr/~dinkmadu/projekt/Treseta/app/images/wood.jpg");
            background-color: #36454F; */
            opacity: 0.9;
            width: 400px;
        }
        td {
            border : 0px;
            height : 200px;
            width : 110px;
        }

        #hand {
            text-align : center;
            position : absolute;
            left : 50%;
            bottom : 5px;
            /* background-color: #36454F; */
            width : 50vw;
            height : 200px;
            overflow : hidden;
            display: inline-block;
            transform: translate(-50%, 0%);
        }
        body {
            background-color : lightgreen;
            overflow : hidden;
        }
        #score{
            padding-right: 20px;
            text-align: middle;
            font-size: 26px;
            position: absolute;
            right: 0;
            top: 5%;
        }
        #us{
            border: 3px solid black;
            height: 50px;
        }
        #them{
            border: 3px solid black;
            height: 50px;
        }
        #head{
            border: 3px solid black;
            height: 50px;
        }
        #score_table{
            border-collapse: collapse;
        }
        #turn{
            position: absolute;
            top: 20px;
            right: 50%;
            text-align: middle;
            font-size: 50px;
        }
    </style>
</head>
<body>
    <div id="position" style="display : none;"><?php echo (int) $_SESSION["position"]; ?></div>
    <div id="roomNumber" style="display : none;"><?php echo (int) $_SESSION["roomNumber"]; ?></div>
    <div id="turn"></div>
    <div id="score">
        <table id="score_table">
            <tr>
                <th id="head" colspan="2">Rezultat</th>
            </tr>
            <tr>
                <td id="us"></td><td id="them"></td>
            </tr>
        </table>
    </div>
    <div class="playing_field">
        <div id="hand" class="hand"></div><button id="c" class="call">AKUŽAJ</button>
        <table id="pool" class = "center">
            <tr>
                <td></td> <td id="<?php echo "t"; echo ((int) $_SESSION["position"] + 2) % 4; ?>" class = "table"></td> <td></td>
            </tr>
            <tr>
                <td id="<?php echo "t"; echo ((int)$_SESSION["position"] + 1) % 4; ?>" class = "table"></td> <td></td> <td id="<?php echo "t"; echo ((int)$_SESSION["position"] + 3) % 4; ?>" class = "table"></td>
            </tr>
            <tr>
                <td></td> <td id="<?php echo "t"; echo $_SESSION["position"]; ?>" class = "table"></td> <td></td>
            </tr>
        </table>
    </div>
    <div class = "score_field"></div>
    <script>
        function update_hand(){
            $.ajax({
                url : "../index.php?rt=game/getHand",
                data : {
                    position : $("#position").html(),
                    roomNumber : $("#roomNumber").html()
                },
                method : "POST",
                dataType : "json",  
                success : show
            });
        }

        function show(hand){
            let src = null;
            let box = null;

            for (let i = 0; i < hand.length; i++){
                src = `../app/card_art/${hand[i]}`;
                box = $(`<div class='box' id = "${i}"></div>`);
                box.append(`<img src="${src}" class="card">`);
                $("#hand").append(box);
            }
        }

        function clickable(){
            updateScore();
            card_id = null;

            $("#hand").on("click", ".box", function() {
                console.log(`clicked: ${this.id}`);
                card_id = this.id;
                // playing of a card should be reflected in the game state
                $.ajax({
                    url : "../index.php?rt=game/play",
                    data : {
                        played : this.id,
                        position : $("#position").html(),
                        roomNumber : $("#roomNumber").html()
                    },
                    method : "POST",
                    dataType : "json",  
                    // on success take the card from the player
                    success : function(resp) {
                        if(resp.msg == "illegal") {
                            warning();
                            return;
                        }
                        if(resp.msg == "wrong_action") {
                            alert(`Wrong action!`);
                            return;
                        }
                        if(resp.msg == "added") {
                            $(`#${card_id}>img`).css("filter", "grayscale(100%)");
                            return;
                        }
                        if(resp.msg == "removed") {
                            $(`#${card_id}>img`).css("filter", "grayscale(0%)");
                            return;
                        }
                        placeCard(resp);
                    }
                });
            });
        }

        function warning(){
            alert("Illegal move!");
        }

        function placeCard(resp){
            disableHand();

            // get and remove card from the hand
            let box = $(`#${resp.msg[1]}`);
            box.remove();

            // place the card on the pool
            $(`#t${resp.msg[0]}`).html("").append(box);

            if(resp.msg[2] == "c") {
                setTimeout(() => {
                    // empty the pool
                    for (let i = 0; i < 4; i++){
                        $(`#t${i}`).html("");
                    }
                    if(resp.msg[4] == "s") {
                        updateScore();
                    }
                }, 1500);
            }
            $("#turn").html("");
            waitTurn();
        }

        function updateScore(){
            $.ajax({
                url : "../index.php?rt=game/getScores",
                data : {
                    roomNumber : $("#roomNumber").html()
                },
                method : "POST",
                dataType : "json",
                success : function(resp){
                    console.log("score updated"); // not working
                    let scorePoints = resp.msg;
                    let position = $("#position").html();
                    $("#us").html("").append(scorePoints[position % 2]);
                    $("#them").html("").append(scorePoints[(position + 1) % 2]);
                }
            });
        }

        function callable(){
            $("#c").css("background-image: linear-gradient(-180deg, #013220, #320113);");
            $("#c").on("click", function(){
                $.ajax({
                    url : "../index.php?rt=game/call",
                    data : {
                        roomNumber : $("#roomNumber").html(),
                        position : $("#position").html()
                    },  
                    method : "POST",
                    dataType : "json",  
                    success : function(resp) {
                        if(resp.msg == "wrong_action") {
                            alert("Not in calling phase!");
                            return;
                        }
                        $(`img`).css("filter", "grayscale(0%)");
                        console.log(`call: ${resp.object}`);
                        $("#c").css("disabled", "true");
                        $("#c").css("background-image", "linear-gradient(-180deg, #B2BEB5, #36454F);");
                    }  
                });
            });

        }

        function showPoll(){
            // first empty
            for (let i = 0; i < 4; i++){
                $(`#t${i}`).html("");
            }
            // draws a poll
            $.ajax({
                url: "../index.php?rt=game/returnPolls",
                data: {
                    roomNumber : $("#roomNumber").html(),
                    position: $("#position").html()
                },
                method: "POST",
                dataType: "json",
                success: function(resp){
                    console.log(resp.msg);
                    // list of poll cards is in resp.msg (ie resp.msg[1]="b1.jpg")
                    let src = null;
                    let box = null;
                    for (let i = 0; i < 4; i++){
                        let pollCard = resp.msg[i];

                        // check if there is a card on the table
                        if (pollCard != ".jpg"){
                            src = `../app/card_art/${poolCard}`;
                            box = $(`<div class="box" id="pool${i}"></div>`);
                            box.append(`<img src="${src}" class="card">`);
                            $(`#t${i}`).html(box);
                        }
                        
                    }
                }
            });
        }

        // wait until its your turn
        function waitTurn(){
            // await also check the win
            $.ajax({
                url : "../index.php?rt=game/await",
                data : {
                    position : $("#position").html(),
                    roomNumber : $("#roomNumber").html()
                },
                method : "POST",
                dataType : "json",  
                success : function(resp) {
                    if (resp.msg == "winner"){
                        let position = $("#position").html();
                        let winner = resp.object;
                        let didWe = (position + winner) % 2;
                        if (didWe == 0) alert("Čestitam, pobjedili ste!");
                        else alert("Izgubili ste. Više sreće drugi put.");
                        //erase the session
                        $.ajax({
                            url : "../index.php?rt=game/invalidate",
                            data : {
                                roomNumber : $("#roomNumber").html()
                            },
                            method : "POST",
                            dataType : "json"
                        });
                        window.location.href = "../index.php";
                        exit();
                    }
                    // resp.msg is 1 when hand is empty, 2 otherwise
                    // this updates the hand only when the new starts
                    if (resp.msg == 1){
                        console.log("update");
                        update_hand();
                    }
                    showPoll();
                    $("#turn").html("Vaš je potez!");
                    clickable();
                    
                }  
            });
        }

        function disableHand(){
            $("#hand").off("click");
        }

        function start() {
            update_hand();  // gets hand cards from server
            disableHand();  // makes hand not clickable
            waitTurn();     // requests server to notify about their turn
        }

        $(document).ready(function(){
            start();
            callable();
            $(window).on("unload", function(){
                $.ajax({
                    url : "../index.php?rt=game/invalidate",
                    data : {
                        roomNumber : $("#roomNumber").html()
                    },
                    method : "POST",
                    dataType : "json",
                    async : false
                });
            });
        });
    </script>
</body>
</html>