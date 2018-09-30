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
 * FRAMEWORK GENERAL SETTINGS
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 */

$showTimeExecution = true; //Show on page the time of execution (true | false)

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

class SQL_KEY
{
    const SELECT = "SELECT";
    const SELECT_DISTINCT = "SELECT_DISTINCT";
    const UPDATE = "UPDATE";
    const DELETE = "DELETE";
    const FROM = 'FROM';
    const INSERT_INTO = "INSERT INTO";
    const CREATE_DATABASE = "CREATE DATABASE";
    const ALTER_DATABASE = "ALTER DATABASE";
    const CREATE_TABLE = "CREATE_TABLE";
    const ALTER_TABLE = "ALTER TABLE";
    const DROP_TABLE = "DROP TABLE";
    const CREATE_INDEX = "CREATE INDEX";
    const DROP_INDEX = "DROP INDEX";
}

class SELECT_KEY
{
    const COUNT = 'COUNT';
    const MIN = 'MIN';
    const MAX = 'MAX';
    const AVG = 'AVG';
    const SUM = 'SUM';
}

class FROM_JOIN
{
    const INNER_JOIN = 'INNER JOIN';
    const LEFT_JOIN = 'LEFT JOIN';
    const LEFT_OUTER_JOIN = 'LEFT OUTER JOIN';
    const RIGHT_JOIN = 'RIGHT JOIN';
    const RIGHT_OUTER_JOIN = 'RIGHT OUTER JOIN';
    const FULL_JOIN = 'FULL JOIN';
    const FULL_OUTER_JOIN = 'FULL OUTER JOIN';
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