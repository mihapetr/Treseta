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
    
    for (let i = 0; i < hands.length; i++) {
        $("#h" + i).html(hands[i]);        
    }
}

$(document).ready(main());

function main() {

    $.ajax({
        url : "index.php?rt=open/start",
        data : {
            
        },
        method : "POST",
        dataType : "html",  
        success : null   
    });

    update_hands();
}