<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trešeta</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
</head>
<body>
    

    <script>
        $(window).unload(function(){
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