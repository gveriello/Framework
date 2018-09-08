<?php

class OrmHelper
{
    private static $server;
    private static $user;
    private static $password;
    private static $database;
    private static $typedatabase;
    public static $db;

    public static function initialize($dbconfigurator)
    {
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
		try{
			self::$db = new PDO(
				self::$typedatabase.':host='.self::$server.';dbname='.self::$database.';charset=utf8mb4',
				self::$user,
				self::$password
			);
			self::config();
		}
		catch (PDOException $e) {
			throw new PDOException("Failed to connect database");
		}
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
                $tempClass->{$property} = $row[$property];
            array_push($result, $tempClass);
            unset($tempClass);
        }
        return $result;
    }
	private static function resultToArray($result)
	{
		$newResult = array();
		foreach($result as $record => $index)
		{
			$row = array();
			foreach($index as $property => $value)
				$row[$property] = $value;
			array_push($newResult, $row);
		}
		return $newResult;
	}

    public static function getTable($class, $toArray = false)
    {
        if (!class_exists($class))
            throw new Exception("Classresult must be a class");

        $classTemp = new $class();
        $query = 'SELECT <fields> FROM <table>';
        $query = str_replace('<table>', get_class($classTemp), $query);
        $fields = array();
        foreach($classTemp as $property => $value)
            array_push($fields, $property);
        $fields = implode(', ', $fields);
        $query = str_replace('<fields>', $fields, $query);

        $result = self::executeQuery($query, $class);
		if ($toArray)
			return self::resultToArray($result);
		return $result;
    }
}
