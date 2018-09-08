<?php
abstract class Rules
{
    private $value;
    private $message;
    abstract function __construct($_value, $_message = '');
    abstract function Execute();
    abstract function GetMessage();
}
abstract class RulesComparator
{
    private $value;
    private $comparator;
    private $message;
    abstract function __construct($_value, $_comparator, $_message = '');
    abstract function Execute();
    abstract function GetMessage();
}
abstract class Action
{
    private $value;
    private $message;
    abstract function __construct($_value);
    abstract function Execute();
}
#region Class with Action
class Trim extends Action
{
    private $value;
    private $message;
    function __construct($_value)
    {
        $this->value = $_value;
    }
    function Execute()
    {
        $_REQUEST[$this->value] = trim($_REQUEST[$this->value]);
        return true;
    }
}
#endregion
#region Class with Rules
class IsNumeric extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
        $this->message = $_message;
    }
    function Execute()
    {
        if (is_numeric($this->value)) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
class IsFloat extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
        $this->message = $_message;
    }
    function Execute()
    {
        if (is_float($this->value)) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
class Required extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
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
class IsEmail extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
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
class IsUrl extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
        $this->message = $_message;
    }
    function Execute()
    {
        if (filter_var($this->value, FILTER_VALIDATE_URL)) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
class IsIP extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
        $this->message = $_message;
    }
    function Execute()
    {
        if (filter_var($this->value, FILTER_VALIDATE_IP)) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
class IsTaxCode extends Rules
{
    private $value;
    private $message;
    function __construct($_value, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
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
        $this->value = $_REQUEST[$_value];
        $this->comparator = $_REQUEST[$_comparator];
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
class Differs extends RulesComparator
{
    private $value;
    private $comparator;
    private $message;
    function __construct($_value, $_comparator, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
        $this->comparator = $_REQUEST[$_comparator];
        $this->message = $_message;
    }
    function Execute()
    {
        if ($this->value !== $this->comparator) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
class ExactLength extends RulesComparator
{
    private $value;
    private $comparator;
    private $message;
    function __construct($_value, $_comparator, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
        $this->comparator = $_comparator;
        $this->message = $_message;
    }
    function Execute()
    {
        if (strlen($this->value) === $this->comparator) return true;
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
        $this->value = $_REQUEST[$_value];
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
        $this->value = $_REQUEST[$_value];
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
class RegularExpression extends RulesComparator
{
    private $value;
    private $comparator;
    private $message;
    function __construct($_value, $_comparator, $_message = '')
    {
        $this->value = $_REQUEST[$_value];
        $this->comparator = $_comparator;
        $this->message = $_message;
    }
    function Execute()
    {
        if (preg_match($this->comparator, $this->value)) return true;
        return false;
    }
    function GetMessage()
    {
        return $this->message;
    }
}
#endregion