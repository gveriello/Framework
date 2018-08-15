<?php

class ViewBag
{
    static private $Bag = array();

    public static function Add($KeyBag, $ItemBag){
        if ($KeyBag !== null){
            self::$Bag[$KeyBag] = $ItemBag;
        }else{
            foreach ($ItemBag as $key => $value) {
                self::$Bag[$key] = $value;
            }
        }
    }
    function getBag(){
        return self::$Bag;
    }
}