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
            background-image: url("https://rp2.studenti.math.hr/~dinkmadu/projekt/Treseta/app/images/wood.jpg");
            background-color: #36454F;
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
            background-color: #36454F;
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
    </style>
</head>
<body>
    <div id="position" style="display : none;"><?php echo (int) $_SESSION["position"]; ?></div>
    <div id="roomNumber" style="display : none;"><?php echo (int) $_SESSION["roomNumber"]; ?></div>
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
                success : function(resp){
                    show(resp);
                    console.log("success_hand");
                }
            });
        }

        function show(hand){
            let src = null;
            let box = null;
            for (let i = 0; i < hand.length; i++){
                src = `../app/card_art/${hand[i]}`;
                box = $(`<div class='box' id = "${i}"></div>`);
                box.append(`<img src="${src}" class="card">`);
                $(`#hand`).append(box);
            }
            console.log("show");
        }

        function clickable(){
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
                        place_card(resp);
                    }
                });
            });
        }

        function warning(){
            alert("Illegal move!");
        }

        function placeCard(resp){
            $.ajax({
                url: "../index.php?rt=game/updatePool",
                data: {
                    roomNumber : $("#roomNumber").html()
                },
                method: "POST",
                dataType: "json",
                success : function(resp){
                    console.log(resp.msg);
                    // treba jos
                }
            });

            $.ajax({
                url: "../index.php?rt=game/waitOthers",
                data: {},
                method: "POST",
                dataType: "json"
            });

        }

        function updateScore(){
            $.ajax({
                url : "../index.php?rt=game/getScores",
                data : {
                    roomNumber : $("#roomNumber").html()
                },
                method : "POST",
                dataType : "json",  
                success : function(resp) {
                    console.log(resp);
                }
            });
        }

        function callable(){
            $(".call").on("click", function(){
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
                    }  
                });
            });
        }

        function waitTurn(i){
            $.ajax({
                url : "../index.php?rt=game/await",
                data : {
                    position : i,
                    roomNumber : $("#roomNumber").html()
                },
                method : "POST",
                dataType : "json",  
                success : function(resp) {
                    console.log(`enabled hand ${i}`);
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
            waitTurn($(`#position`).html());     // requests server to notify about their turn
            
            // $.ajax({
            //     url: "../index.php?rt=game/waitOthers",
            //     data: {
            //         roomNumber : $("#roomNumber").html(),
            //         position : $("#position").html()
            //     },
            //     method: "POST",
            //     dataType: "json"
            // });
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