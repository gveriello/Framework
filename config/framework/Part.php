<?php
namespace App;

class Part {

    protected $part;
    protected $action;
    protected $phpbehind;
    protected $jsbehind;
    protected $layout;
    protected $model;
    protected $querystring;

    function __construct($_part, $_action, $querystring, $_phpbehind, $_jsbehind, $_layout, $_model) {
        $this->part = $_part;
        $this->action = $_action;
        $this->querystring = $querystring;
        $this->phpbehind = $_phpbehind;
        $this->jsbehind = $_jsbehind;
        $this->layout = $_layout;
        $this->model = $_model;

        $this->phpbehind = new $_phpbehind();
    }

    function set($name,$value) {
        $this->_template->set($name,$value);
    }

    function __destruct() {
           // $this->_template->render();
    }

}