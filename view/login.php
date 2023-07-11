<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
        Korisničko ime:
        <input type="text" name="username">
        <br>
        <br>
        Željena pozicija:
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
</body>
</html>