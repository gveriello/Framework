<?php
#region ROUTING FUNCTIONS

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Routing functions
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

function request_uri()
{
    return sprintf( "%s", $_SERVER['REQUEST_URI'] );
}

function get_routing($url, &$page, &$action, &$querystring, &$phpbehind, &$jsbehind, &$layout, &$model)
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
        if (count($urlArray) === 1)
            $page = $urlArray[0];
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
        if (count($_GET) > 0) 
            $querystring = parse_query_string($_GET);
    }
    $page = ucwords(strtolower($page));
    $phpbehind = $page.'PHP';
    $layout = $page.'Layout';
    $model = $page.'Model';
    $jsbehind = $page.'JS';
}

function parse_query_string($array)
{
    $NewArray = array();
    if (is_array($array))
        foreach($array as $key => $item)
            $NewArray[$key] = $item;
    return $NewArray;
}
#endregion



#region SECURITY FUNCTIONS

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Security functions
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

function strip_slashes_deep($value)
{
    return is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
}

function remove_magic_quotes()
{
    if ( get_magic_quotes_gpc() ) {
        $_GET    = strip_slashes_deep($_GET   );
        $_POST   = strip_slashes_deep($_POST  );
        $_COOKIE = strip_slashes_deep($_COOKIE);
    }
}

function unregister_globals()
{
    if (ini_get('register_globals') == 0) return;
    $variables = array(
        'REQUEST', 'GET', 'POST', 'COOKIE',
        'SESSION', 'FILES', 'ENV', 'SERVER'
    );
    // Save the existing superglobals first
    foreach ($variables as $variable)
        if (isset(${'_' . $variable}))
            ${'local_' . $variable} = ${'_' . $variable};
    // Unset the $GLOBALS array (clear all)
    foreach($GLOBALS as $key => $value)
        if ($key != 'GLOBALS')
            unset($GLOBALS[$key]);
    // Re-assign the saved superglobals again
    foreach ($variables as $variable)
        if (isset(${'local_' . $variable}))
            ${'_' . $variable} = ${'local_' . $variable};
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value)
            foreach ($GLOBALS[$value] as $key => $var)
                if ($var === $GLOBALS[$key])
                    unset($GLOBALS[$key]);
    }
}

function set_reporting()
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
#endregion

#region FRAMEWORK FUNCTIONS

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Framework functions
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

function can_allocate($folder, $file)
{
    if ($folder !== NULL && $file !== NULL && $folder !== '' && $file !== '')
        return (!empty(string_for_allocate_file($folder, $file)));
    return false;
}

function allocate($folder, $file, $databag = array())
{
    if (count($databag) > 0)
        extract($databag);
    if (can_allocate($folder, $file))
        require_once string_for_allocate_file($folder, $file);
}

function string_for_allocate_file($folder, $file)
{
    $file = pathinfo($file, PATHINFO_FILENAME); //prendo solo il nome del file eliminando l' eventuale estensione
    $extension = '.php';
    if (is_dir($folder.DS.$file))
        return $folder.DS.$file;
    else
        if (!empty($folder) && !empty($file))
        {
            switch($folder){

                case JSBEHIND:
                case JS:
                    $extension = '.js';
                    break;
                case CSS:
                    $extension = '.css';
                    break;
            }
            if (file_exists($folder.DS.$file.$extension))
                return $folder.DS.$file.$extension;
            return '';
        }
    return '';
}

function validate_fields($_style = '', $_class = '')
{
    if (!empty($_REQUEST["formattributevalidator"]))
    {
        $errorvalidator = array();
        $messagevalidator = array();
        $_formatattributevalidator = json_decode(base64_decode($_REQUEST["formattributevalidator"]));
        if ($_formatattributevalidator !== NULL)
        {
            Allocator::allocate_library('DataValidator');
            Allocator::allocate_helper('StringerHelper');
            if (password_verify(json_encode($_formatattributevalidator->configurator), base64_decode($_formatattributevalidator->token)))
            {
                $_formatattributevalidator = $_formatattributevalidator->configurator;
                foreach($_formatattributevalidator as $value => $rules)
                {
                    $validatorresult = false;
                    foreach($rules as $rule)
                    {
                        $message = StringerHelper::after($rule, ',');
                        $comparator = StringerHelper::between($rule, '[', ']');
                        $validator = null;
                        if ($comparator !== '')
                        {
                            $rule = StringerHelper::before($rule, '[');
                            $validator = new $rule($value, $comparator, $message);
                            $validatorresult = $validator->Execute();
                        }
                        else
                        {
                            $rule = StringerHelper::before($rule, ',');
                            $validator = new $rule($value, $message);
                            $validatorresult = $validator->Execute();
                        }
                        if (!$validatorresult)
                        {
                            array_push($errorvalidator, $rule);
                            array_push($messagevalidator, $validator->GetMessage());
                        }
                    }
                }
                if (count($errorvalidator) > 0)
                    return array("result" => false, "rules" => $errorvalidator, "message" => $messagevalidator);
                else
                    return array("result" => true, "rules" => "", "message" => "");
            }

        }
        else
            throw new ParserException("Validation Library require that doesn't exist more input called 'formattributevalidator'");
    }
}

function redirect_page($_page, $action = 'index', $querystring = array())
{
    $StringQueryString = '';
    if (count($querystring) > 0){
        $KeysOfQueryString = array_keys($querystring);
        for ($KeysOfQueryStringI = 0; $KeysOfQueryStringI < count($KeysOfQueryString); $KeysOfQueryStringI++){
            $StringQueryString .= $KeysOfQueryString[$KeysOfQueryStringI]."/".$querystring[$KeysOfQueryString[$KeysOfQueryStringI]]."/";
        }
    }
    return '/'.$_page.'/'.$action.'/'.(count($querystring) > 0 ? $StringQueryString : '');
}
#endregion

#region INTERNAL ERROR

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Method of internal error
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */
function show_404()
{
    global $errorpages;
    if (array_key_exists("404", $errorpages))
    {
        if (file_exists($errorpages["404"]))
            require_once $errorpages["404"];
        return;
    }
    else
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
    }
}

function show_500()
{
    if (array_key_exists("500", $errorpages))
    {
        if (file_exists($errorpages["500"]))
            require_once $errorpages["500"];
        return;
    }
    else
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    }
}
#endregion