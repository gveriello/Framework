<?php

class PHPBehind extends Page{

    public $querystring = array();

    function __construct() {
    }

    public function setQueryString($_querystring){
        if (is_array($_querystring))
            $this->querystring = $_querystring;
    }
    public function getQueryString(){
        return $this->querystring;
    }
}