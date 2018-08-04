<?php

class ViewBag
{
    private $Bag;
    function __construct(){
        $this->Bag  = array();
    }
    function Add($KeyBag, $ItemBag){
        if ($KeyBag !== null){
            $this->Bag[$KeyBag] = $ItemBag;
        }else{
            foreach ($ItemBag as $key => $value) {
                $this->Bag[$key] = $value;
            }
        }
    }
    function getBag(){
        return $this->Bag;
    }
}