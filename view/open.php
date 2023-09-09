<!-- EXTERNAL STYLESHEET I SCRIPT NE RADE DOBRO ??? -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trešeta</title>
    <!--<link rel="stylesheet" type="text/css" href="openStyle.css" >-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <!--<script src="openScript.js"></script>-->    
    <style>
.box {
    display  : inline-block;
    width : 50px;
    overflow : hidden;
}
.box:hover {
    width : auto;
    position : relative;
    /*top : 20px;*/
}
.box:last-child {
    width : auto;
}
.card {
    border-radius : 10px;
    border : 1px solid black;
    height : 200px;
}
.hand {
    text-align : center;
    border : 1px solid red;
    width : 60vw;
    height : 120px;
    overflow : hidden;
    display: inline-block;
}
body {
    background-color : #a8853e;
    /*overflow : hidden;*/
}
#pool {
    position : absolute;
    top : 0px;
    right : 0px;
}

td {
    border-radius : 10px;
    border : 1px solid black;
    height : 200px;
    width : 110px;
}
    </style>
</head>
<body>
    
<div id="main">
    P0:<div id="h0" class="hand"></div><button id="c0" class="call">call_0</button><br><br>
    P1:<div id="h1" class="hand"></div><button id="c1" class="call">call_1</button><br><br>
    P2:<div id="h2" class="hand"></div><button id="c2" class="call">call_2</button><br><br>
    P3:<div id="h3" class="hand"></div><button id="c3" class="call">call_3</button><br><br>
    <table id="pool">
    <tr>
        <td></td> <td id="t2" class="table">P2</td> <td></td>
    </tr>
    <tr>
        <td id="t1" class="table">P1</td> <td></td> <td id="t3" class="table">P3</td>
    </tr>
    <tr>
        <td></td> <td id="t0" class="table">P0</td> <td></td>
    </tr>
    </table>
    <hr>
    call: <div id="display"></div>
    <hr>
    piles:<br>
    P0:<div id="p0" class="pile"></div><br><br>
    P1:<div id="p1" class="pile"></div><br><br>
    P2:<div id="p2" class="pile"></div><br><br>
    P3:<div id="p3" class="pile"></div><br><br>
    <hr>
    scores: <div id="scores"></div>
    <button onclick="update_score()">scores</button>
</div>

<script>

// call for controller to initialize the game
function start() {

    $.ajax({
        url : "test.index.php?rt=open/index",
        data : {},
        method : "POST",
        dataType : "json",  
        success : function(resp) {
            console.log(resp.msg);
            update_hands();
            for(let i=0; i<4; i++) {
                disable_hand(i);    // disable all hands
                wait_turn(i);   // i-th player asks the server to be notified about their turn
            }
        }  
    });
}

// fetch the state of every player's hands (initial state)
function update_hands() {

    $.ajax({
        url : "test.index.php?rt=open/getHands",
        data : {},
        method : "POST",
        dataType : "json",  
        success : show
    });
}

// display every hand
function show(hands) {

    //console.log(hands);
    let src = null;
    let box = null;
    for (let i = 0; i < hands.length; i++) {
        for (let j = 0; j < hands[i].length; j++) {
            src = `../app/card_art/${hands[i][j]}`;
            box = $(`<div class='box' id="${i}${j}"></div>`);     // every card is in a container "box" : css
            box.append(`<img src="${src}" class="card">`);      // every card is a "card" : css
            $(`#h${i}`).append(box);    // hand i has id="hi"
        }

    }
}

// make cards clickable
function clickable() {

    // to pass to the success function
    card_id = null;

    $(".hand").on("click", ".box", function() {
        console.log(`clicked: ${this.id}`);
        card_id = this.id;
        // playing of a card should be reflected in the game state
        // todo: add a turn condition
        // todo: add a legal condition
        $.ajax({
            url : "test.index.php?rt=open/play",
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

// in case it is an illegal move
function warning() {

    alert("Illegal move!");
}

// update what the player just played
function place_card(resp) {

    let player = resp.msg[0];
    // if the request was legal, disable the players hand
    disable_hand(player);

    // get and remove the box that was clicked
    let box = $(`#${resp.msg[0]}${resp.msg[1]}`);
    box.remove();

    // place the card on the table
    $(`#t${resp.msg[0]}`).html("").append(box);
    // if the server said "c" cards from the pool were collected
    if(resp.msg[2] == "c") {
        setTimeout(() => {
            // add to the pile
            let pileCards = $(".table").children();
            $(`#p${resp.msg[3]}`).append(pileCards);
            // empty the pool
            $("td").html(``);
            if(resp.msg[4] == "s") {
                update_score();
                update_hands(); // new dealing, new hands
                $(".pile").html("");
            }
        }, 1500);       // time that passes before cards are not displayed any more
    }

    wait_turn(player);
}

// testing the auto calculator
function update_score() {

    $.ajax({
        url : "test.index.php?rt=open/getScores",
        data : {},
        method : "POST",
        dataType : "json",  
        success : function(resp) {
            console.log(resp);
        }
    });
}

// buttons for calling the "akužavanje"
function callable() {

    $(".call").on("click", function(){
        $.ajax({
            url : "test.index.php?rt=open/call",
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

// long polling
function wait_turn(i) {

    $.ajax({
        url : "test.index.php?rt=open/await",
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

function enable_hand(i) {
    $(`#h${i}`).show();
    $(`#c${i}`).show();
}

function disable_hand(i) {
    $(`#h${i}`).hide();
    $(`#c${i}`).hide();
}

$(document).ready(function(){
    start();    // create an new table in the database
    clickable();    // make cards clickable
    callable();     // button for akužavanje (for now just skips turn)
    $(window).on("unload",function(){
        $.ajax({
            url : "index.php?rt=open/invalidate",
            data : {},
            method : "POST",
            dataType : "json",
            success : function(resp){
                console.log(resp);
            }
        });
    });
});

</script>

</body>
</html>