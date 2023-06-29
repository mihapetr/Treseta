<?php

// inicjalna verzija s interneta
// potreban review, ali izgleda dobro

function obj($key) {

    switch ($key) {
        case 'card':
            return new Card();
            break;
        case 'hand':
            return new Hand(); 
            break;
        case 'pile':
            return new Pile();
            break;
        case 'player':
            return new Player("",-1);
            break;
        case 'pool':
            return new Pool();
            break;
        default:
            //
            break;
    }
}

function loadJSON($Obj, $json)
{
    $dcod = json_decode($json);
    $prop = get_object_vars ( $dcod );
    foreach($prop as $key => $lock)
    {
        if(property_exists ( $Obj ,  $key ))
        {
            if(is_object($dcod->$key))
            {
                // get object class and make a new one
                $loaded = obj($key);
                //echo "loading prop: " . $key . "<br>";
                loadJSON($loaded, json_encode($dcod->$key));
                $Obj -> $key = $loaded;
            }
            elseif($key == "players") {
                $Obj -> players = [];
                foreach ($dcod -> $key as $key => $player) {
                    $loadedPlayer = new Player("", -1);
                    loadJson($loadedPlayer, json_encode($player));
                    $Obj -> set_player($loadedPlayer);
                }
            }
            elseif($key == "cards") {
                $Obj -> cards = [];
                foreach ($dcod -> $key as $key => $card) {
                    $loadedCard = new Card("","","","");
                    loadJson($loadedCard, json_encode($card));
                    $Obj -> push($loadedCard);
                }
            }
            else
            {
                $Obj->$key = $dcod->$key;
            }
        }
    }
    return $Obj;
}
?>

<?php
/*class Name
{
  public $first;
  public $last;
  public function fullname()
  {
    return $this->first . " " . $this->last;
  }
}
$json = '{"first":"John","last":"Smith"}';

$infull = loadJSON((new Name), $json);
echo $infull->fullname();*/
?>