<?php
class IndexModel
{
    public $textoftable = 'ciao';
    public $name = 'a';
    public $surname = 'v';
    public $arrayoftable;
    public $table;

    function __construct(){
        $this->arrayoftable = array();
        $this->arrayoftable[0] = array("a" => "b", "c" => "d", "e" => "f");
        $this->arrayoftable[1] = array("a" => "h", "c" => "2", "e" => "3");
        $this->arrayoftable[2] = array("c" => 10);

        $this->table = array();
        $this->table[0] = array("Id" => 1, "Nome_device" => "samsung" );
        $this->table[1] = array("Id" => 2, "Nome_cell" => "prova");
        $this->table[2] = array("Id" => 3, "Nome_cell" => "prova");
        //c'è un bug, verificare
        $this->table[2] = array("Nome_cell" => "prova", "Nome_device" => "samsung" );
        $this->table[3] = array("Nome_cell" => "prova", "Nome_device" => "samsung" );
    }
}
