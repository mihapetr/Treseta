<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

</head>
<body>
    <form action="index.php?rt=login/analyzeLogin" method="post">
        Username:
        <input type="text" name="username">
        <br>
        <br>
        Position:
        <input type="radio" name="position" value="0" checked = "checked">
        <label for="0">1.</label>
        <input type="radio" name="position" value="1">
        <label for="1">2.</label>
        <input type="radio" name="position" value="2">
        <label for="2">3.</label>
        <input type="radio" name="position" value="3">
        <label for="3">4.</label>
        <br>
        <br>
        <button type="submit">Uđi u igru!</button>
    </form>
    <script>
        // function that adds a player if possible
        function analyze(){
            $.ajax({
                url : "index.php?rt=login/analyzeLogin",
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