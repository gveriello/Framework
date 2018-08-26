<?php

class ViewBag
{
    static private $Bag = array();


    public static function Length()
    {
        return count(self::$Bag);
    }

    public static function AddModel($model)
    {
        foreach($model as $property => $value)
        {
            if (!is_array($value))
                self::Add($property, $value);
        }
    }
    public static function Add($KeyBag, $ItemBag)
    {
        if ($KeyBag !== null){
            self::$Bag[$KeyBag] = $ItemBag;
        }else{
            foreach ($ItemBag as $key => $value) {
                self::$Bag[$key] = $value;
            }
        }
    }

    function getBag()
    {
        return self::$Bag;
    }

    function getValue($key)
    {
        return self::$Bag[$key];
    }

    function getValueByKeyString($string_key)
    {
        $list_of_key = explode('.', $string_key);
        if (count($list_of_key) === 0)
            return self::getValue($string_key);
        else
        {
            $actual_position = self::$Bag[$list_of_key[0]];
            for ($i = 1; $i < count($list_of_key); $i++)
                $actual_position = $actual_position[$list_of_key[$i]];
            return $actual_position;
        }

    }
}