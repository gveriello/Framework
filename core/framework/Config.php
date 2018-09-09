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
    FRAMEWORK => '*',
	ORMCLASSES => '*'
    );

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * CONNECTOR TO DATABASE
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * Connector used to database connect
 */

$dbconfigurator = array(
    "use" => "db1",
    "databases" => array(
        "db1" => array("typedatabase" => DBType::MYSQL, "host" => 'localhost', "username" => 'root', "password" => '', "database" => 'db_test')
    )
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

class SELECT_KEY
{
    const COUNT = 'COUNT';
    const MIN = 'MIN';
    const MAX = 'MAX';
    const AVG = 'AVG';
    const SUM = 'SUM';
}
class WHERE_KEY
{
    const EQUAL = '=';
    const NOT_EQUAL = '<>';
    const GREATER_THAN = '>';
    const LESS_THAN = '<';
    const GREATER_THAN_OR_EQUAL = '>=';
    const LESS_THAN_OR_EQUAL = '<=';
    const BETWEEN = 'BETWEEN';
    const NOT_BETWEEN = 'NOT BETWEEN';
    const LIKE = 'LIKE';
    const IN = 'IN';
    const NOT_IN = 'NOT IN';
}

class OPERATOR_KEY
{
    const AND_KEY = 'AND';
    const OR_KEY = 'OR';
    const NOT_KEY = 'NOT';
}
#endregion