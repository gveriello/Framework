<?php
class Page {

    protected function getPage(){
        return $GLOBALS['page'];
    }

    protected function getPHPBehind(){
        return $GLOBALS["phpbehind"];
    }

    protected function getJSBehind(){
        return $GLOBALS["jsbehind"];
    }

    protected function getLayout(){
        return $GLOBALS['layout'];
    }

    protected function getModel(){
        return $GLOBALS['model'];
    }

    protected function getAction(){
        return $GLOBALS['action'];
    }

    protected function getQueryString(){
        return $GLOBALS['querystring'];
    }


}
function show404(){
    Allocate(PAGES, '404');
}

function show(){

}