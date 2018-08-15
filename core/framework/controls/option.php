<?php
class option extends FormControl
{
	private $attribute;
    private $value;

    function __construct()
    {
    		$this->attribute = array();
    		$this->value = array();
    }
        
    function set_value($_attribute, $_value)
    {
    	array_push($this->attribute, $_attribute);
    	array_push($this->value, $_value);
    }

    function get_value($_attribute)
    {
    	return $this->value(array_search($_attribute, $this->attribute));
    }
    
}