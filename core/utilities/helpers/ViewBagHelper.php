<?php

class ViewBagHelper
{
    static private $Bag = array();


    public static function Length()
    {
        return count(self::$Bag);
    }

    public static function AddObject($model)
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

    public static function GetBag()
    {
        return self::$Bag;
    }

    public static function GetValueByKey($key)
    {
        return self::$Bag[$key];
    }

    public static function GetValueByKeyString($string_key)
    {
        $list_of_key = explode('.', $string_key);
        if (count($list_of_key) === 0)
            return self::GetValueByKey($string_key);
        else
        {
            $actual_position = self::$Bag[$list_of_key[0]];
            for ($i = 1; $i < count($list_of_key); $i++)
                $actual_position = $actual_position[$list_of_key[$i]];
            return $actual_position;
        }

    }
}