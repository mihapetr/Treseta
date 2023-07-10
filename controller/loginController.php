<?php

require_once __DIR__ . "/../model/login.class.php";
require_once __DIR__ . "/../app/database/db.class.php";

class loginController
{
    // starts the login process
    public function index($errorMsg = "")
    {
        if ($errorMsg !== "") echo $errorMsg;
        session_start();
        require_once __DIR__ . "/../view/login.php";
    }

    public function anaylzeLogin()
    {
        if (!isset($_POST["username"]))
        {
            echo "Nije postavljeno korisničko ime!";
            exit();
        }

        if( !preg_match( "/^[a-zA-Z]{3,20}$/", $_POST["username"] ) )
	    {
            $this->index("Ime mora imati 3-20 slova!");
            exit();
	    }

        $db = DB::getConnection();

        $username = $_POST["username"];
        $position = $_POST["position"];

        // check if the game is full
        try
        {
            $st = $db->prepare("SELECT * FROM users");
            $st->execute();
        }
        catch(PDOException $e) { exit("Greška u bazi: " . $e->getMessage());}
        if ($st->rowCount() === 4)
        {
            $this->index("Igra je puna");
            exit();
        }

        // check for user with the same name
        try
        {
            $st = $db->prepare("SELECT id FROM users WHERE username=:username");
            $st->execute(array("username" => $username));
        }
        catch(PDOException $e) { exit("Greška u bazi: " . $e->getMessage());}

        $row = $st->fetch();

        if ($row !== false){
            $this->index("Postoji korisnik s tim imenom!");
            exit();
        }

        // check for user with the same position
        try
        {
            $st = $db->prepare("SELECT username FROM users WHERE id=:id");
            $st->execute(array("id" => $position));
        }
        catch(PDOException $e) { exit("Greška u bazi: " . $e->getMessage());}

        $row = $st->fetch();

        if ($row !== false){
            $this->index("Postoji korisnik s tim imenom!");
            exit();
        }

        // after all the checks, add the user to the database
        try
        {
            $st = $db->prepare("INSERT INTO users(id, username) VALUES (:id, :username");
            $st->execute(array("id" => $position, "username" => $username));
        }
        catch (PDOException $e) { exit("Greška u bazi: " . $e->getMessage());}
    }
};

?>