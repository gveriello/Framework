<?php
#region CONST FOLDER
define('DS', DIRECTORY_SEPARATOR, true); // slash /
define('ROOT', __DIR__); //root del sito

define('API', ROOT.DS.'api');

define('APPLICATION', ROOT.DS.'application');
define('MODEL', APPLICATION.DS.'model');
define('PHPBEHIND', APPLICATION.DS.'phpbehind');
define('JSBEHIND', APPLICATION.DS.'jsbehind');
define('LAYOUT', APPLICATION.DS.'layout');

define('CORE', ROOT.DS.'core');
define('DB', CORE.DS.'db');
define('FRAMEWORK', CORE.DS.'framework');
define('CONTRACTS', FRAMEWORK.DS.'contracts');
define('LIBRARIES', FRAMEWORK.DS.'libraries');
define('LANGUAGE', CORE.DS.'language');
define('HELPER', CORE.DS.'helper');

define('RESOURCES', ROOT.DS.'resources');
define('CSS', RESOURCES.DS.'css');
define('JS', RESOURCES.DS.'js');
define('IMG', RESOURCES.DS.'img');
define('PAGES', RESOURCES.DS.'pages');

define('SECURITY', ROOT.DS.'security');
define('LOG', RESOURCES.DS.'log');
define('ATTACHMENTS', RESOURCES.DS.'attachments');
#endregion
#region ENVIRONMENT STATUS
class ENVIRONMENTSTATUS
{
    const DEVELOP = 0;
    const TEST = 1;
    const PRODUCTION = 2;
}
const ENVIRONMENT = ENVIRONMENTSTATUS::DEVELOP;
#endregion

#region GLOBAL'S VARIABLE
$url;
$page;
$phpbehind;
$jsbehind;
$action;
$querystring;
$layout;
$model;
#endregion
/** Resources that loaded when page starts to load **/
/** If you want load other class, add reference here **/
require (FRAMEWORK.DS.'Core.php');
require (CONTRACTS.DS.'PageContracts.php');
require (CONTRACTS.DS.'PHPBehindContracts.php');
require (CONTRACTS.DS.'ModelContracts.php');
require (FRAMEWORK.DS.'FrameworksHelper.php');
/** Get request URL **/
$url = ltrim(RequestUri(), '/');
$url = rtrim($url, '/');

SetReporting();
RemoveMagicQuotes();
UnRegisterGlobals();
Main();