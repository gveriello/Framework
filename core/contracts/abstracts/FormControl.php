<?php

    abstract class FormControl
    {
    
      private $attribute;
      private $value;
      private $child;
        
      abstract function set_value($_attribute, $_value);  

      abstract function get_value($_attribute);
        
      abstract function add_child($_child);    
        
    }




