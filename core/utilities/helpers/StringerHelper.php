<?php
class StringerHelper
{
    public static function After($value, $character)
    {
        if (!is_bool(strpos($value, $character)))
            return substr($value, strpos($value, $character) + strlen($character));
    }

    public static function AfterLast($value, $character)
    {
        if (!is_bool(self::StrRevPos($value, $character)))
            return substr($value, self::StrRevPos($value, $character)+strlen($character));
    }

    public static function Before($value, $character)
    {
        return substr($value, 0, strpos($value, $character));
    }

    public static function BeforeLast($value, $character)
    {
        return substr($value, 0, self::StrRevPos($value, $character));
    }

    public static function Between($value, $_start, $_stop)
    {
        $string = " ".$value;
        $ini = strpos($string, $_start);
        if ($ini == 0) return "";
        $ini += strlen($_start);
        $len = strpos($string, $_stop, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public static function BetweenLast($value, $character, $that)
    {
        return self::AfterLast($character, self::BeforeLast($value, $that));
    }

    public static function StrRevPos($instr, $needle)
    {
        $rev_pos = strpos (strrev($instr), strrev($needle));
        if ($rev_pos === false) return false;
        else return strlen($instr) - $rev_pos - strlen($needle);
    }

    public static function IsHtml($string)
    {
        if($string != strip_tags($string))
            return true;
        return false;
    }

    public static function Join($separator = '', $element = array())
    {
        return implode($separator, $element);
    }
}