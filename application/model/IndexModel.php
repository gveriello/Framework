<?php
class IndexModel extends PageModel{

    public $textoftable = 'ciao';

    public $name = 'a';
    public $surname = 'v';
    public $arrayoftable;

    function __construct(){
        $this->arrayoftable = array();
        $this->arrayoftable[0] = array("a" => "b", "c" => "d", "e" => "f");
        $this->arrayoftable[1] = array("a" => "h", "c" => "2", "e" => "3");
        $this->arrayoftable[2] = array("c" => 10);
    }
}