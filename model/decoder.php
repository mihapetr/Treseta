<?php

// inicjalna verzija s interneta
// potreban review, ali izgleda dobro

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
                loadJSON($Obj->$key, json_encode($dcod->$key));
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

Tested with:

<?php
class Name
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
echo $infull->fullname();