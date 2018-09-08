<?php

class OrmHelper
{
    private $server;
    private $user;
    private $password;
    private $database;
    private $typedatabase;
    public $db;

    private static function initialize()
    {
        global $dbconfigurator;
        if (is_array($dbconfigurator))
        {
            $configuration = $dbconfigurator['databases'][$dbconfigurator['use']];
            if (is_array($configuration))
            {
                self::$server = $configuration['host'];
                self::$user = $configuration['username'];
                self::$password = $configuration['password'];
                self::$database = $configuration['database'];
                self::$typedatabase = $configuration['typedatabase'];
                return true;
            }
        }
        return false;
    }
    private static function checkparameters()
    {
        if (!is_null(self::$server))
            if (!is_null(self::$database))
                if (!is_null(self::$typedatabase))
                    if (!is_null(self::$user))
                        if (!is_null(self::$password))
                            return true;
        return false;
    }
    private static function config()
    {
        //Configuration variable.
        if (ENVIRONMENT == ENVIRONMENTSTATUS::DEVELOP)
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (ENVIRONMENT == ENVIRONMENTSTATUS::TEST)
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        if (ENVIRONMENT == ENVIRONMENTSTATUS::TEST)
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    }
    public static function connect()
    {
        if (self::initialize())
            if (self::checkparameters())
            {
                self::$db = new PDO(
                    self::$typedatabase.':host='.self::$server.';dbname='.self::$database.';charset=utf8mb4',
                    self::$user,
                    self::$password
                );
                self::config();
                return true;
            }
        throw new Exception("Failed to connect database");
    }
    private static function executeQuery($queryString, $class)
    {
        if (is_null($queryString) || !class_exists($class))
            throw new Exception("Querystring and Classresult is required");

        $executedQuery = self::$db->query($queryString);
        $result = array();
        while($row = $executedQuery->fetch(PDO::FETCH_ASSOC)) {
            $tempClass = new $class();
            foreach($tempClass as $property => $value)
                $value = $row[$value];
            array_push($result, $tempClass);
            unset($tempClass);
        }
    }

    public static function getTable($class)
    {
        if (!class_exists($class))
            throw new Exception("Classresult must be a class");

        $query = 'SELECT <fields> FROM <table>';
        $query = str_replace('<table>', get_class($class), $query);
        $fields = array('?');
        foreach($class as $property)
            array_push($fields, $property);
        $fields = implode(', ', $fields);
        $query = str_replace('<fields>', $fields, $query);

        return self::executeQuery($query, $class);
    }
}
