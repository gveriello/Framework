<?php

abstract class Rules
{
    private $value;
    private $message;
    abstract function __construct($_value, $_message = '');
    abstract function Execute();
    abstract function GetMessage();
}