<?php

abstract class RulesComparator
{
    private $value;
    private $comparator;
    private $message;
    abstract function __construct($_value, $_comparator, $_message = '');
    abstract function Execute();
    abstract function GetMessage();
}