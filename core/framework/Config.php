<?php

#region ENVIRONMENT STATUS
/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * APPLICATION ENVIRONMENT
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the set_reporting() code below
 */
const ENVIRONMENT = ENVIRONMENTSTATUS::PRODUCTION;
#endregion

#region RESOURCES
global $jquery_url;

$jquery_url = 'https://code.jquery.com/jquery-3.3.1.min.js';
#endregion
#region JULIUS CONFIGURATION

global $autoloader;
global $dbconfigurator;
global $errorpages;

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * AUTOLOADER FILE
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * File that autoloaded when Julius is ready
 */

$autoloader = array(
    INTERFACES => '*',
    IMPLEMENTED => '*',
    FRAMEWORK => '*'
    );

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * CONNECTOR TO DATABASE
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * Connector used to database connect
 */

$dbconfigurator = array(
    "databases" => array(
        "db1" => array("typedatabase" => DBType::MYSQL, "host" => NULL, "username" => NULL, "password" => NULL, "database" => NULL)
    ),
    "use" => "db1"
);

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * URL TO ERRORS PAGE
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 */

$errorpages = array(
    "404" => PAGES.DS.'404.php',
    "500" => PAGES.DS.'500.php'
    );

#endregion

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * ENUMS
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * List of enums used in the Julius
 */
class DBType
{
    const MYSQL = 'mysql';
    const SQLSERVER = null;
    const ORACLE = null;
}

class ENVIRONMENTSTATUS
{
    const DEVELOP = 0;
    const TEST = 1;
    const PRODUCTION = 2;
}
#endregion