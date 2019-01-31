<?php
class Page
{
    protected $PageName;
    protected $PHPBehavior;
    protected $JSBehavior;
    protected $Layout;
    protected $Model;
    protected $Action;
    protected $QueryString;

    public function __set($name, $value) 
    {
        $this->$name = $value;
    }
}