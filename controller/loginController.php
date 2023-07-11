<?php

require_once __DIR__ . "/../model/table.class.php";
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
            $this -> index("Nije postavljeno korisničko ime!");
            exit();
        }

        if( !preg_match( "/^[a-zA-Z]{3,20}$/", $_POST["username"] ) )
	    {
            $this->index("Ime mora imati 3-20 slova!");
            exit();
	    }

        $db = DB::getConnection();

        $username = $_POST["username"];
        $position = (int) $_POST["position"];


        $table = Table::load();

        if ($table -> getValid() === false)
        {
            $table = new Table;
            $table -> setValid(true);
            $table -> save();
        }

        try
        {
            $table -> acceptPlayer(new Player($username, $position));
            $table -> save();
        }
        catch(Exception $e)
        {
            echo "Seat taken!";
        }

        $numberOfPlayers = count($table -> players());
        if ($numberOfPlayers === 4)
        {
            $table -> endPhase();
            $table -> save();
        }
        
    }
};

?>