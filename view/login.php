<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

</head>
<body>
    <?php
        $table = Table::load(3);
        echo ($table -> players()[2] -> name());
    ?>
    <form action="index.php?rt=login/analyzeLogin" method="post">
        Unesite korisničko ime:
        <!--Welcome, game rules ...-->
        <input type="text" name="username">
        <br>
        <button type="submit">Uđi u igru!</button>
    </form>
</body>
</html>