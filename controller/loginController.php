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
        
        session_start();

        $_SESSION["username"] = $_POST["username"];

        header( "Location: index.php?rt=lobby" );
        exit();
        
    }
};

?>