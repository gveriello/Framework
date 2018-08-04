<?php
#region CONST FOLDER
define('DS', DIRECTORY_SEPARATOR, true); // slash /
define('ROOT', __DIR__); //root del sito

define('APPLICATION', ROOT.DS.'application');
define('MODEL', APPLICATION.DS.'model');
define('PHPBEHIND', APPLICATION.DS.'phpbehind');
define('JSBEHIND', APPLICATION.DS.'jsbehind');
define('LAYOUT', APPLICATION.DS.'layout');

define('CONFIG', ROOT.DS.'config');
define('DB', CONFIG.DS.'db');
define('FRAMEWORK', CONFIG.DS.'framework');
define('LANGUAGE', CONFIG.DS.'language');

define('HELPER', ROOT.DS.'helper');

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
require (DB.DS.'Connector.php');
require (FRAMEWORK.DS.'Page.php');
require (HELPER.DS.'HelperFunction.php');
require (HELPER.DS.'FrameworksHelper.php');
require (FRAMEWORK.DS.'PHPBehind.php');
require (FRAMEWORK.DS.'Model.php');
/** Get request URL **/
$url = ltrim(RequestUri(), '/');
$url = rtrim($url, '/');

SetReporting();
RemoveMagicQuotes();
UnRegisterGlobals();
Main();