<?php
class Page {

    public $page;
    public $action;
    public $phpbehind;
    public $jsbehind;
    public $layout;
    public $model;
    public $querystring;

    function __construct($_page, $_action, $querystring, $_phpbehind, $_jsbehind, $_layout, $_model) {
        $this->part = $_page;
        $this->action = $_action;
        $this->querystring = $querystring;
        $this->jsbehind = $_jsbehind;
        $this->layout = $_layout;
        $this->phpbehind = new $_phpbehind();
        $this->model = new $_model();
    }
    function __destruct() {
    }

}