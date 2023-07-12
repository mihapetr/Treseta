<?php

require_once __DIR__ . "/../model/table.class.php";

// sending messages to the client
class Message {
    public $object;
    public $msg;
    function __construct($o, $m) {
        $this -> object = $o;
        $this -> msg = $m;
    }
};

class gameController {

    
    function index() {
        require_once __DIR__ . "/../view/game.php";
    }

    function invalidate(){
        $table = Table::load();
        $table -> setValid(false);
        session_unset();
        session_destroy();
    }
};

?>