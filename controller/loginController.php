<?php

require_once __DIR__ . "/../model/table.class.php";

class loginController
{
    // starts the login process
    public function index()
    {
        require_once __DIR__ . "/../view/login.php";
    }

    public function analyzeLogin()
    {
        if (!isset($_POST["username"]) || !preg_match( "/^[a-zA-Z]{3,20}$/", $_POST["username"]))
        {
            header ("Location : index.php?rt=login");
            exit();
        }

        if (session_id() === "") session_start();

        $db = DB::getConnection();

        $username = $_POST["username"];
        $position = (int) $_POST["position"];

        $table = Table::load();

        if ($table -> getValid() === false)
        {
            $table = new Table;
            $table -> setWho($position);
            $table -> save();
        }

        try
        {
            $table -> acceptPlayer(new Player($username, $position));
            $table -> save();
        }
        catch(Exception $e)
        {
            $this -> index();
            return;
        }

        $_SESSION["username"] = $username;
        $_SESSION["position"] = $position;

        $numberOfPlayers = count($table -> players());
        
        // if all 4 players are seated, the game can start
        if ($numberOfPlayers === 4)
        {
            $table -> endPhase();
            $table -> save();
            header( "Location: index.php?rt=game" );
            exit();
        }

        // if not, go to the waiting room
        else
        {
            header( "Location: index.php?rt=waitingRoom" );
            exit();
        }
        
    }
};

?>