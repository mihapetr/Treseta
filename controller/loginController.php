<?php

require_once __DIR__ . "/../model/table.class.php";

class loginController
{
    // starts the login process
    public function index($errorMsg = "")
    {
        if ($errorMsg !== "") alert($errorMsg);
        require_once __DIR__ . "/../view/login.php";
    }

    public function anaylzeLogin()
    {
        if (!isset($_POST["username"]))
        {
            $this -> index("Username not set!");
        }

        if( !preg_match( "/^[a-zA-Z]{3,20}$/", $_POST["username"] ) )
	    {
            $this->index("Please enter a name with 3-20 letters.");
	    }

        session_start();

        $db = DB::getConnection();

        $username = $_POST["username"];
        $position = (int) $_POST["position"];
        echo $username;

        $table = Table::load();

        if ($table -> getValid() === false)
        {
            $table = new Table;
            $table -> save();
        }

        try
        {
            $table -> acceptPlayer(new Player($username, $position));
            $table -> save();
        }
        catch(Exception $e)
        {
            $this -> index("Seat taken!");
        }

        $_SESSION["username"] = $username;
        $_SESSION["position"] = $position;

        $numberOfPlayers = count($table -> players());
        
        // if all 4 players are seated, the game can start
        if ($numberOfPlayers === 4)
        {
            $table -> endPhase();
            $table -> save();
            header( 'Location: index.php?rt=game' );
        }

        // if not, go to the waiting room
        else
        {
            header( 'Location: index.php?rt=waitingRoom' );
        }
        
    }
};

?>