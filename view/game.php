<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trešeta</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <style>
        .player_call{
            position: fixed;
            left: 50%;
            bottom: 20px;
            transform: translate(-50%, -50%);
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div id="position" style="display : none;"><?php echo $_SESSION["position"];?></div>
    <div id="player_call"><div id="player"></div><button id="c_player" class = "call">CALL</button></div>
    <script>
        function update_hand(){
            $.ajax({
                url : "test.index.php?rt=game/getHand",
                data : {},
                method : "POST",
                dataType : "json",  
                success : show   
            });
        }

        function clickable(){
            card_id = null;

            $(".hand").on("click", ".box", function() {
                console.log(`clicked: ${this.id}`);
                card_id = this.id;
                // playing of a card should be reflected in the game state
                $.ajax({
                    url : "test.index.php?rt=game/play",
                    data : {
                        played : this.id
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
            let player = parseInt($("#position").html());
            disableHand();
            let box = $(`#${player}`);
        }

        function updateScore(){
            $.ajax({
                url : "test.index.php?rt=game/getScores",
                data : {},
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
                    url : "test.index.php?rt=game/call",
                    data : {
                        player : this.id[1]
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

        function waitTurn(){
            $.ajax({
                url : "test.index.php?rt=game/await",
                data : {
                    player : i
                },
                method : "POST",
                dataType : "json",  
                success : function(resp) {
                    console.log(`enabled hand ${i}`);
                    enable_hand(i);
                }  
            });
        }

        function enableHand(){

        }

        function disableHand(){
            let i = parseInt($("#position").html());

        }

        $(document).ready(main());

        function main(){

        }

        $(window).on("unload", function(){
            $.ajax({
                url : "index.php?rt=game/invalidate",
                data : {},
                method : "POST",
                dataType : "json",
                success : function(resp){
                    console.log(resp);
                }
            });
        });
    </script>
</body>
</html>