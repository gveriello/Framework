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

function RedirectPage($_page, $action = 'index', $querystring = array()){
    $StringQueryString = '';
    if (count($querystring) > 0){
        $KeysOfQueryString = array_keys($querystring);
        for ($KeysOfQueryStringI = 0; $KeysOfQueryStringI < count($KeysOfQueryString); $KeysOfQueryStringI++){
            $StringQueryString .= $KeysOfQueryString[$KeysOfQueryStringI]."/".$querystring[$KeysOfQueryString[$KeysOfQueryStringI]]."/";
        }
    }
    return $_page.'/'.$action.(count($querystring) > 0 ? $StringQueryString : '');
}

function show404(){
    Allocate(PAGES, '404');
}

function show(){

}