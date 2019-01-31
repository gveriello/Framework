<?php
$startExecution = microtime();
#region FRAMEWORK CONST
/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * CONSTANT
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * Constant that load all directory of Julius.
 * DON'T CHANGE THEM
 */

define('DS', DIRECTORY_SEPARATOR, true); // slash /
define('ROOT', __DIR__); //root del sito

define('API', ROOT.DS.'api');

define('APPLICATION', ROOT.DS.'application');
define('MODEL',         APPLICATION.DS.'model');
define('BEHAVIOR',      APPLICATION.DS.'behavior');
define('CONTROLLER',    APPLICATION.DS.'controller');
define('JSBEHIND',      APPLICATION.DS.'jsbehind');
define('LAYOUT',        APPLICATION.DS.'layout');

define('CORE',      ROOT.DS.'core');
define('CONTRACTS',     CORE.DS.'contracts');
define('ABSTRACTS',         CONTRACTS.DS.'abstracts');
define('IMPLEMENTED',       CONTRACTS.DS.'implemented');
define('INTERFACES',        CONTRACTS.DS.'interfaces');
define('FRAMEWORK',     CORE.DS.'framework');
define('CONTROLS',     FRAMEWORK.DS.'controls');
define('LANGUAGES',     CORE.DS.'languages');
define('UTILITIES',     CORE.DS.'utilities');
define('HELPERS',       UTILITIES.DS.'helpers');
define('LIBRARIES',     UTILITIES.DS.'libraries');

define('RESOURCES', ROOT.DS.'resources');
define('CSS',           RESOURCES.DS.'css');
define('JS',            RESOURCES.DS.'js');
define('IMG',           RESOURCES.DS.'img');
define('FONTS',         RESOURCES.DS.'fonts');
define('PAGES',         RESOURCES.DS.'pages');

define('RESERVED',  ROOT.DS.'reserved');
define('LOG',           RESERVED.DS.'log');
define('CACHE',         RESERVED.DS.'cache');
define('ORMCLASSES',    RESERVED.DS.'ormclasses');
define('ATTACHMENTS',   RESERVED.DS.'attachments');
#endregion

#region FRAMEWORK GLOBAL
/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * APPLICATION ENVIRONMENT
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * Globals variable of Julius.
 * DON'T CHANGE THEM
 */

$url;
$page;
$controller;
$jsbehind;
$action;
$querystring;
$layout;
$model;
#endregion

require_once 'core/framework/GlobalFunctions.php';
require_once 'core/framework/Config.php';
require_once 'core/framework/Julius.php';