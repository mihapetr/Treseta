<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting Room</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
</head>
<body>
    Waiting for all 4 players.
    <br>
    <script>
        $(document).ready(loop());

        function loop(){
            $.ajax({
                url : "index.php?rt=waitingRoom/wait",
                data : {},
                method : "POST",
                dataType : "json",
                success : function(resp){
                    console.log(resp);
                }
            });
        }
    </script>
</body>
</html>

<?php

?>