<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game room</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
</head>
<body>
    <!-- Choose a position -->
    <form action="index.php?rt=gameRoom/addPlayer" method="post">
    <button type="submit" name="position" value="0">1.</button>
    <br>
    <button type="submit" name="position" value="1">2.</button>
    <br>
    <button type="submit" name="position" value="2">3.</button>
    <br>
    <button type="submit" name="position" value="3">4.</button>
    </form>
</body>
</html>