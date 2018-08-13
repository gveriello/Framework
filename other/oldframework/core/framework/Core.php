<?php

function Main() {
    global $url;
    global $page;
    global $phpbehind;
    global $jsbehind;
    global $action;
    global $querystring;
    global $layout;
    global $model;
    GetRouting($url, $page, $action, $querystring, $phpbehind, $jsbehind, $layout, $model);
    if (CanAllocate('layout', $layout)){
        if (CanAllocate('model', $model)){
            if (CanAllocate('phpbehind', $phpbehind)){
                Allocate(JSBEHIND, $jsbehind);
                Allocate(MODEL, $model);
                Allocate(PHPBEHIND, $phpbehind);
                $dispatch = new $phpbehind();
                $GLOBALS = array(
                    'page' => $page,
                    'phpbehind' => $dispatch,
                    'jsbehind' => $jsbehind,
                    'layout' => $layout,
                    'model' => new $model(),
                    'action' => $action,
                    'querystring' => $querystring
                );
                if ((int)method_exists($dispatch, $action)) {
                    call_user_func_array(array($dispatch, $action), array());
                } else {
                    show404();
                }
            }else{
                show404();
            }
        }else{
            show404();
        }
    }else{
        show404();
    }
}

function AllocateFramework()
{
}
function RequestUri(){
    return sprintf(
      "%s",
      $_SERVER['REQUEST_URI']
    );
}

function CanAllocate($folder, $file)
{
    if ($folder !== NULL && $file !== NULL && $folder !== '' && $file !== ''){
        switch($folder){
            case 'layout':
                $extension = '.php';
                if (file_exists(LAYOUT.DS.$file.$extension)){
                    return true;
                }
                return false;
            case 'model':
                $extension = '.class.php';
                if (file_exists(MODEL.DS.$file.$extension)){
                    return true;
                }
                return false;
            case 'phpbehind':
                $extension = '.class.php';
                if (file_exists(PHPBEHIND.DS.$file.$extension)){
                    return true;
                }
                return false;
            case 'jsbehind':
                $extension = '.js';
                if (file_exists(JSBEHIND.DS.$file.$extension)){
                    return true;
                }
                return false;
            case PAGES:
                $extension = '.php';
                if (file_exists(PAGES.DS.$file.$extension)){
                    return true;
                }
                return false;
            case API:
                $extension = '.php';
                if (file_exists(API.DS.$file.$extension)){
                    return API.DS.$file.$extension;
                }
                return false;
            case CONTRACTS:
                $extension = '.php';
                if (file_exists(CONTRACTS.DS.$file.$extension)){
                    return CONTRACTS.DS.$file.$extension;
                }
                return false;
            case LIBRARIES:
                $extension = '.php';
                if (file_exists(LIBRARIES.DS.$file.$extension)){
                    return LIBRARIES.DS.$file.$extension;
                }
                return false;
            default:
                $extension = '.php';
                if (file_exists($folder.DS.$file.$extension)){
                    return $folder.DS.$file.$extension;
                }
                return false;
        }
    }
    return false;
}

function Allocate($folder, $file, $databag = array())
{
    if (count($databag) > 0) extract($databag);
    if (file_exists(StringForAllocateFile($folder, $file)))
        require_once StringForAllocateFile($folder, $file);
}


function RedirectPage($_page, $action = 'index', $querystring = array()){
    $StringQueryString = '';
    if (count($querystring) > 0){
        $KeysOfQueryString = array_keys($querystring);
        for ($KeysOfQueryStringI = 0; $KeysOfQueryStringI < count($KeysOfQueryString); $KeysOfQueryStringI++){
            $StringQueryString .= $KeysOfQueryString[$KeysOfQueryStringI]."/".$querystring[$KeysOfQueryString[$KeysOfQueryStringI]]."/";
        }
    }
    return $_page.'/'.$action.'/'.(count($querystring) > 0 ? $StringQueryString : '');
}

function show404(){
    Allocate(PAGES, '404');
}

function show(){

}

function ExtractVariable($data = array())
{
    for($i = 0; $i < count($data); $i++){

    }
}

function StringForAllocateFile($folder, $file)
{
    if ($folder !== NULL && $file !== NULL && $folder !== '' && $file !== ''){
        switch($folder){
            case CORE:
                $extension = '.php';
                if (file_exists(CORE.DS.$file.$extension)){
                    return CORE.DS.$file.$extension;
                }
                return false;
            case LAYOUT:
                $extension = '.php';
                if (file_exists(LAYOUT.DS.$file.$extension)){
                    return LAYOUT.DS.$file.$extension;
                }
                return false;
            case MODEL:
                $extension = '.class.php';
                if (file_exists(MODEL.DS.$file.$extension)){
                    return MODEL.DS.$file.$extension;
                }
                return false;
            case PHPBEHIND:
                $extension = '.class.php';
                if (file_exists(PHPBEHIND.DS.$file.$extension)){
                    return PHPBEHIND.DS.$file.$extension;
                }
                return false;
            case JSBEHIND:
                $extension = '.js';
                if (file_exists(JSBEHIND.DS.$file.$extension)){
                    return JSBEHIND.DS.$file.$extension;
                }
                return false;
            case PAGES:
                $extension = '.php';
                if (file_exists(PAGES.DS.$file.$extension)){
                    return PAGES.DS.$file.$extension;
                }
                return false;
            case HELPER:
                $extension = '.php';
                if (file_exists(HELPER.DS.$file.$extension)){
                    return HELPER.DS.$file.$extension;
                }
                return false;
            case API:
                $extension = '.php';
                if (file_exists(API.DS.$file.$extension)){
                    return API.DS.$file.$extension;
                }
                return false;
            case CONTRACTS:
                $extension = '.php';
                if (file_exists(CONTRACTS.DS.$file.$extension)){
                    return CONTRACTS.DS.$file.$extension;
                }
                return false;
            case LIBRARIES:
                $extension = '.php';
                if (file_exists(LIBRARIES.DS.$file.$extension)){
                    return LIBRARIES.DS.$file.$extension;
                }
                return false;
            default:
                $extension = '.php';
                if (file_exists($folder.DS.$file.$extension)){
                    return $folder.DS.$file.$extension;
                }
                return false;
        }
    }
    return false;
}


function GetRouting($url, &$page, &$action, &$querystring, &$phpbehind, &$jsbehind, &$layout, &$model)
{
    $page  = 'Index';
    $action = 'index';
    $querystring = array();
    $phpbehind  = 'Index';
    $layout = 'Index';
    $model = 'Index';
    if ($url !== '' && $url !== NULL){
        $urlArray = array();
        $urlArray = explode("/", $url);
        if (count($urlArray) === 1){
            $page = $urlArray[0];
        }
        if (count($urlArray) === 2){
            $page = $urlArray[0];
            $action = $urlArray[1];
        }
        if (count($urlArray) > 2){
            $page = $urlArray[0];
            array_shift($urlArray);
            $action = $urlArray[0];
            array_shift($urlArray);
        }
        if (count($_GET) > 0) $querystring = ParseQueryString($_GET);
    }
    $page = ucwords(strtolower($page));
    $phpbehind = $page.'PHP';
    $layout = $page.'Layout';
    $model = $page.'Model';
    $jsbehind = $page.'JS';
}

function ParseQueryString($array)
{
    $NewArray = array();

    if (is_array($array)){
        foreach($array as $key => $item){
            $NewArray[$key] = $item;
        }
    }
    return $NewArray;
}

function SetReporting()
{
    if (ENVIRONMENT === 0) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else if (ENVIRONMENT === 1) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else if (ENVIRONMENT === 2) {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
    }
}

function StripSlashesDeep($value)
{
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function RemoveMagicQuotes()
{
    if ( get_magic_quotes_gpc() ) {
        $_GET    = stripSlashesDeep($_GET   );
        $_POST   = stripSlashesDeep($_POST  );
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

function UnRegisterGlobals()
{
    if (ini_get('register_globals') == 0) return;
    $variables = array(
        'REQUEST', 'GET', 'POST', 'COOKIE',
        'SESSION', 'FILES', 'ENV', 'SERVER'
    );
    // Save the existing superglobals first
    foreach ($variables as $variable) {
        if (isset(${'_' . $variable})) {
            ${'local_' . $variable} = ${'_' . $variable};
        }
    }
    // Unset the $GLOBALS array (clear all)
    foreach($GLOBALS as $key => $value) {
        if ($key != 'GLOBALS') {
            unset($GLOBALS[$key]);
        }
    }
    // Re-assign the saved superglobals again
    foreach ($variables as $variable) {
        if (isset(${'local_' . $variable})) {
            ${'_' . $variable} = ${'local_' . $variable};
        }
    }
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }

    }
}

