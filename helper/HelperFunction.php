<?php

function RequestUri(){
    return sprintf(
      "%s",
      $_SERVER['REQUEST_URI']
    );
}

//function that start when all is ready
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
                if (CanAllocate('jsbehind', $jsbehind)){
                    Allocate(JSBEHIND, $jsbehind);
                    Allocate(MODEL, $model);
                    Allocate(PHPBEHIND, $phpbehind);
                    $dispatch = new Page($page, $action, $querystring, $phpbehind, $jsbehind, $layout, $model);
                    if ((int)method_exists($dispatch->phpbehind, $action)) {
                        call_user_func_array(array($dispatch->phpbehind,$action), array());
                    } else {
                        echo 'Action non esistente 404';
                    }
                }else{
                    echo '<br>JS 404';
                }
            }else{
                echo '<br>PHP 404';
            }
        }else{
            echo '<br>Model 404';
        }
    }else{
        echo '<br>Layout 404';
    }
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
            default:
                return false;
        }
    }
    return false;
}

function Allocate($folder, $file){
    require_once StringForAllocateFile($folder, $file);
}
function StringForAllocateFile($folder, $file)
{
    if ($folder !== NULL && $file !== NULL && $folder !== '' && $file !== ''){
        switch($folder){
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
            default:
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
            $querystring = ParseQueryString($urlArray);
        }
    }
    $page = ucwords(strtolower($page));
    $phpbehind = $page.'PHP';
    $layout = $page.'Layout';
    $model = $page.'Model';
    $jsbehind = $page.'JS';

    //echo 'L\'url è: '.$url.'<br>';
    //echo 'Il nome della pagina è: '.$page.'<br>';
    //echo 'Il phpbehind è: '.$phpbehind.'<br>';
    //echo 'Il jsbehind è: '.$jsbehind.'<br>';
    //echo 'Il model è: '.$model.'<br>';
    //echo 'Il layout è: '.$layout.'<br>';
    //echo 'L\' action è: '.$action.'<br>';
    //echo 'La querystring è: '.print_r($querystring);
}

function ParseQueryString($array){
    $NewArray = array();
    if (is_array($array)){
        for ($i = 0; $i < count($array); $i = $i + 2){
            if ($array[$i] !== NULL){
                if ($array[$i + 1] === NULL)
                    $NewArray[$array[$i]] = NULL;
                else
                    $NewArray[$array[$i]] = $array[$i+1];
            }
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