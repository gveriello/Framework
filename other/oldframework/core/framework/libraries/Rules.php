<?php

/**
 * Class to validate only value
 */
abstract class Rules
{
    private $value;
    private $message;
    abstract function __construct($_value, $_message = '');
    abstract function Execute();
    abstract function GetMessage();
}

/**
 * Class to validate value with another value
 */
abstract class RulesComparator
{
    private $value;
    private $comparator;
    private $message;
    abstract function __construct($_value, $_comparator, $_message = '');
    abstract function Execute();
    abstract function GetMessage();
}

#region Class with Rules
class Required extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_value;
        $this->message = $_message;
    }
    function Execute()
    {
        if (empty($this->value)) return false;
        return true;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
class Email extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_value;
        $this->message = $_message;
    }
    function Execute()
    {
        $this->value = filter_var($this->value, FILTER_SANITIZE_EMAIL);
        if (filter_var($this->value, FILTER_VALIDATE_EMAIL)) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
class TaxCode extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_value;
        $this->message = $_message;
    }
    function Execute()
    {
        if (strlen($this->value) === 16) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
#endregion

#region Classes with RulesComparator
class Matches extends RulesComparator
{
    private $value;
    private $comparator;
    private $message;
    function __construct($_value, $_comparator, $_message = '')
    {
        $this->value = $_value;
        $this->comparator = $_comparator;
        $this->message = $_message;
    }
    function Execute()
    {
        if ($this->value === $this->comparator) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
class MinLength extends RulesComparator
{
    private $value;
    private $comparator;
    private $message;
    function __construct($_value, $_comparator, $_message = '')
    {
        $this->value = $_value;
        $this->comparator = $_comparator;
        $this->message = $_message;
    }
    function Execute()
    {
        if (strlen($this->value) > $this->comparator) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
class MaxLength extends RulesComparator
{
    private $value;
    private $comparator;
    private $message;
    function __construct($_value, $_comparator, $_message = '')
    {
        $this->value = $_value;
        $this->comparator = $_comparator;
        $this->message = $_message;
    }
    function Execute()
    {
        if (strlen($this->value) < $this->comparator) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
#endregion