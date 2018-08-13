<?php
class StringerHelper
{
    private $value;

    function __construct($_value)
    {
        $this->value = $_value;
    }

    function after ($character)
    {
        if (!is_bool(strpos($this->value, $character)))
            return substr($this->value, strpos($this->value, $character) + strlen($character));
    }

    function after_last ($character)
    {
        if (!is_bool($this->strrevpos($this->value, $character)))
            return substr($this->value, $this->strrevpos($this->value, $character)+strlen($character));
    }

    function before ($character)
    {
        return substr($this->value, 0, strpos($this->value, $character));
    }

    function before_last ($character)
    {
        return substr($this->value, 0, $this->strrevpos($this->value, $character));
    }

    function between ($_start, $_stop)
    {
        $string = " ".$this->value;
        $ini = strpos($string, $_start);
        if ($ini == 0) return "";
        $ini += strlen($_start);
        $len = strpos($string, $_stop, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function between_last ($character, $that)
    {
        return $this->after_last($character, $this->before_last($that));
    }
}