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
}
body {
    background-color : lightgreen;
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
    P0<div id="h0" class="hand"></div>
    P1<div id="h1" class="hand"></div>
    P2<div id="h2" class="hand"></div>
    P3<div id="h3" class="hand"></div>
    <table id="pool">
    <tr>
        <td></td> <td id="c2"></td> <td></td>
    </tr>
    <tr>
        <td id="c1"></td> <td></td> <td id="c3"></td>
    </tr>
    <tr>
        <td></td> <td id="c0"></td> <td></td>
    </tr>
    </table>
</div>

<script>

function start() {

$.ajax({
    url : "index.php?rt=open/index",
    data : {},
    method : "POST",
    dataType : "json",  
    success : null  
});
}

// update the state of every player's hands
function update_hands() {

$.ajax({
    url : "index.php?rt=open/getHands",
    data : {
        
    },
    method : "POST",
    dataType : "json",  
    success : show   
});
}

function show(hands) {

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

function clickable() {

    $(".hand").on("click", ".box", function() {
        console.log(`clicked: ${this.id}`);
    });
}

$(document).ready(main());

function main() {

    start();
    console.log("initialized game");
    update_hands();
    clickable();
}

</script>

</body>
</html>

