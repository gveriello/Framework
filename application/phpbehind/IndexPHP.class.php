<?php
class IndexPHP extends PHPBehind{

    function __construct($_querystring){
        parent::setQueryString($_querystring);
    }

    public function index(){
        echo '<br>Sono entrato!!!'.json_encode(parent::getQueryString());
    }

    public function login(){
        echo '<br>Accedi!!'.json_encode($this->querystring);
    }
}