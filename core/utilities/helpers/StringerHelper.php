<?php
class StringerHelper
{
    public static function after ($value, $character)
    {
        if (!is_bool(strpos($value, $character)))
            return substr($value, strpos($value, $character) + strlen($character));
    }

    public static function after_last ($value, $character)
    {
        if (!is_bool(self::strrevpos($value, $character)))
            return substr($value, self::strrevpos($value, $character)+strlen($character));
    }

    public static function before ($value, $character)
    {
        return substr($value, 0, strpos($value, $character));
    }

    public static function before_last ($value, $character)
    {
        return substr($value, 0, self::strrevpos($value, $character));
    }

    public static function between ($value, $_start, $_stop)
    {
        $string = " ".$value;
        $ini = strpos($string, $_start);
        if ($ini == 0) return "";
        $ini += strlen($_start);
        $len = strpos($string, $_stop, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public static function between_last ($value, $character, $that)
    {
        return self::after_last($character, self::before_last($value, $that));
    }

    public static function strrevpos($instr, $needle)
    {
        $rev_pos = strpos (strrev($instr), strrev($needle));
        if ($rev_pos === false) return false;
        else return strlen($instr) - $rev_pos - strlen($needle);
    }

    public static function string_is_html($string)
    {
        if($string != strip_tags($string))
            return true;
        return false;
    }

    public static function join($separator = '', $element = array())
    {
        return implode($separator, $element);
    }
}