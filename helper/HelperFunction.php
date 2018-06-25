<?php
namespace App;

function RequestUri(){
    return sprintf(
      "%s",
      $_SERVER['REQUEST_URI']
    );
}

//function that start when all is ready
function Main() {
    global $url;
    global $part;
    global $phpbehind;
    global $jsbehind;
    global $action;
    global $querystring;
    global $layout;
    global $model;
    GetRouting($url, $part, $action, $querystring, $phpbehind, $jsbehind, $layout, $model);

    if (CanAllocate('layout', $layout)){
        if (CanAllocate('model', $model)){
            if (CanAllocate('phpbehind', $phpbehind)){
                if (CanAllocate('jsbehind', $jsbehind)){
                    $dispatch = new $phpbehind($part, $action, $querystring, $phpbehind, $jsbehind, $layout, $model);

                    if ((int)method_exists($phpbehind, $action)) {
                        call_user_func_array(array($dispatch, $action), $querystring);
                    } else {
                        echo '404';
                    }
                }
            }else{
                echo '404';
            }
        }else{
            echo '404';
        }
    }else{
        echo '404';
    }
}

function CanAllocate($folder, $file){
    if ($folder !== NULL && $file !== NULL && $folder !== '' && $file !== ''){
        switch($folder){
            case 'layout':
                if (file_exists(LAYOUT.DB.$file)){
                    require_once(LAYOUT.DB.$file);
                    return true;
                }
                return false;
            case 'model':
                if (file_exists(MODEL.DB.$file)){
                    require_once(MODEL.DB.$file);
                    return true;
                }
                return false;
            case 'phpbehind':
                if (file_exists(PHPBEHIND.DB.$file)){
                    require_once(PHPBEHIND.DB.$file);
                    return true;
                }
                return false;
            case 'jsbehind':
                if (file_exists(JSBEHIND.DB.$file)){
                    require_once(JSBEHIND.DB.$file);
                    return true;
                }
                return false;
            default:
                return false;
        }
    }
    return false;
}

function GetRouting($url, &$part, &$action, &$querystring, &$phpbehind, &$jsbehind, &$layout, &$model){
    $part  = 'Index';
    $action = 'index';
    $querystring = NULL;
    $phpbehind  = 'Index';
    $layout = 'Index';
    $model = 'Index';
    if ($url !== '' && $url !== NULL){
        $urlArray = array();
        $urlArray = explode("/", $url);
        if (count($urlArray) === 1){
            $part = $urlArray[0];
        }
        if (count($urlArray) === 2){
            $part = $urlArray[0];
            $action = $urlArray[1];
        }
        if (count($urlArray) > 2){
            $part = $urlArray[0];
            $action = $urlArray[1];
            $querystring = $urlArray[2];
        }
    }
    $part = ucwords(strtolower($part));
    $phpbehind = $part.'PHPScript';
    $layout = $part.'Layout';
    $model = $part.'Model';
    $jsbehind = $part.'JSScript';

    echo 'L\'url è: '.$url.'<br>';
    echo 'Il controllore è: '.$part.'<br>';
    echo 'Il phpbehind è: '.$phpbehind.'<br>';
    echo 'Il jdbehind è: '.$jsbehind.'<br>';
    echo 'Il model è: '.$model.'<br>';
    echo 'Il layout è: '.$layout.'<br>';
    echo 'L\' action è: '.$action.'<br>';
    echo 'La querystring è: '.$querystring;
}

function SetReporting() {
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

function StripSlashesDeep($value) {
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function RemoveMagicQuotes() {
    if ( get_magic_quotes_gpc() ) {
        $_GET    = stripSlashesDeep($_GET   );
        $_POST   = stripSlashesDeep($_POST  );
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

function UnRegisterGlobals() {
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