<?php
#region ROUTING FUNCTIONS

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Routing functions
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

function RequestUri()
{
    return sprintf( "%s", $_SERVER['REQUEST_URI'] );
}

function InitializeRouting($url, &$page, &$action, &$querystring, &$controller, &$jsbehind, &$layout, &$model, &$behavior)
{
    global $defaultpage;
    global $defaultaction;
    $page  = $defaultpage;
    $action = $defaultaction;
    $querystring = array();
    $controller  = $defaultpage;
    $layout = $defaultpage;
    $model = $defaultpage;
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
            $querystring = ParseQueryString($_GET);
    }
    $page = ucwords(strtolower($page));
    $behavior = ucwords(strtolower($action)).'PHP';
    $controller = $page.'Controller';
    $layout = $page.'Layout';
    $model = $page.'Model';
    $jsbehind = $page.'JS';
}

function ParseQueryString($array)
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

function StripSlashesDeep($value)
{
    return is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
}

function RemoveMagicQuotes()
{
    if ( get_magic_quotes_gpc() ) {
        $_GET    = StripSlashesDeep($_GET   );
        $_POST   = StripSlashesDeep($_POST  );
        $_COOKIE = StripSlashesDeep($_COOKIE);
    }
}

function UnregisterGlobals()
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
#endregion

#region FRAMEWORK FUNCTIONS

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Framework functions
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

function CanAllocate($folder, $file)
{
    return (!empty(PathFileToAllocate($folder, $file)));
}

function Allocate($folder, $file, $databag = array())
{
    if (count($databag) > 0)
        extract($databag);
    if (CanAllocate($folder, $file))
        require_once PathFileToAllocate($folder, $file);
}

function PathFileToAllocate($folder, $file)
{
    if (is_null(folder) || is_null($file) || empty($folder) || empty($file))
        return '';
    
    $file = pathinfo($file, PATHINFO_FILENAME); //prendo solo il nome del file eliminando l' eventuale estensione
    if (is_dir($folder.DS.$file))
        return $folder.DS.$file;
    
    $extension = GetExtensionByFolder($folder);
    if (file_exists($folder.DS.$file.$extension))
        return $folder.DS.$file.$extension;

    return '';
}

function GetExtensionByFolder($folder)
{
    $extension = '.php';
    switch($folder){
        case JSBEHIND:
        case JS:
            $extension = '.js';
            break;
        case CSS:
            $extension = '.css';
            break;
    }
    return $extension;
}

function ValidateRules($_style = '', $_class = '')
{
    if (!empty($_REQUEST["formattributevalidator"]))
    {
        $errorvalidator = array();
        $messagevalidator = array();
        $_formatattributevalidator = json_decode(base64_decode($_REQUEST["formattributevalidator"]));
        if ($_formatattributevalidator !== NULL)
        {
            Allocator::AllocateHelper('DataValidator');
            Allocator::AllocateHelper('Stringer');
            if (password_verify(json_encode($_formatattributevalidator->configurator), base64_decode($_formatattributevalidator->token)))
            {
                $_formatattributevalidator = $_formatattributevalidator->configurator;
                foreach($_formatattributevalidator as $value => $rules)
                {
                    $validatorresult = false;
                    foreach($rules as $rule)
                    {
                        $message = StringerHelper::After($rule, ',');
                        $comparator = StringerHelper::Between($rule, '[', ']');
                        $validator = null;
                        if ($comparator !== '')
                        {
                            $rule = StringerHelper::Before($rule, '[');
                            $validator = new $rule($value, $comparator, $message);
                            $validatorresult = $validator->Execute();
                        }
                        else
                        {
                            $rule = StringerHelper::Before($rule, ',');
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
            throw new Exception("Validation Library require that doesn't exist more input called 'formattributevalidator'");
    }
}

function Binding()
{
    if (!class_exists(HtmlParserHelper))
        Allocator::AllocateHelper("HtmlParser");

    if (!class_exists(ViewBagHelper))
        Allocator::AllocateHelper("ViewBag");

    if (!class_exists(StringerHelper))
        Allocator::AllocateHelper("Stringer");

    if (ViewBagHelper::Length() > 0)
    {
        $controls = HtmlParserHelper::GetAllControls();

        foreach ($controls as $node)
        {
            if (!empty(HtmlParserHelper::GetAttributeByNode($node, 'binding-property')))
            {
                $value = ViewBagHelper::GetValueByKey(HtmlParserHelper::GetAttributeByNode($node, 'binding-property'));
                if (!empty($value))
                    if (StringerHelper::IsHtml($value))
                        HtmlParserHelper::CreateNodeFromHtmlString($node, $value);
                    else
                    {
                        HtmlParserHelper::SetAttributeByNode($node, 'value', $value);
                        HtmlParserHelper::SetNodeValueByNode($node, $value);
                    }
                HtmlParserHelper::RemoveAttributeByNode($node, 'binding-property');
            }
            Event::EventTrigger('OnLayoutBinded');
        }
    }
}

function RedirectTo($_page, $action = 'index', $querystring = array())
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

function InitializePageByInstance($instance)
{
    if (is_null($instance))
        return;

    $instance->PageName = $GLOBALS['page'];
    $instance->PHPBehavior = $GLOBALS['behavior'];
    $instance->JSBehavior = $GLOBALS['jsbehind'];
    $instance->Layout = $GLOBALS["layout"];
    $instance->Model = $GLOBALS['model'];
    $instance->Action = $GLOBALS['action'];
    $instance->QueryString = $GLOBALS['querystring'];
}
#endregion

#region INTERNAL ERROR

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Method of internal error
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */
function Show404()
{
    global $errorpages;
    if (array_key_exists("404", $errorpages))
    {
        if (file_exists($errorpages["404"]))
            require_once $errorpages["404"];
        return;
    }
    else
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
}

function Show500()
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