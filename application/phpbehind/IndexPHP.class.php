<?php
class IndexPHP extends PHPBehind{

    public function index()
    {
        $viewbag = array("title" => parent::getPage());
        Allocate(LAYOUT, parent::getLayout(), $viewbag);
    }

    public function login()
    {

    }

}