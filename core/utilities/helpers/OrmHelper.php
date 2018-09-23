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

                if (!is_null(self::$server))
                    if (!is_null(self::$database))
                        if (!is_null(self::$typedatabase))
                            if (!is_null(self::$user))
                                if (!is_null(self::$password))
                                    return true;

                return false;
            }
        }
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


    private static function executeQuery($queryString, $classes = array())
    {
        if (is_null($queryString))
            throw new Exception("Querystring and Classes are required");

        $executedQuery = self::$db->query($queryString);
        return self::fetchResult($executedQuery, $classes);
    }

    private static function fetchResult($executedQuery, $classes = array())
    {
        if (is_null($executedQuery) || count($classes) === 0)
            throw new Exception("Error during parsing query");

        $result = array();
        while($row = $executedQuery->fetch(PDO::FETCH_ASSOC)) {
            $rowTemp = array();
            foreach($classes as $class)
            {
                $class = new $class();
                foreach($class as $property => $value)
                    $class->{$property} = $row[$property];
                array_push($rowTemp, $class);
                unset($class);
            }
            array_push($result, $rowTemp);
            unset($rowTemp);
        }
        return $result;
    }

    public static function executeQueryByString($query, $classes = array(), $toArray = false)
    {
        $result = self::executeQuery($query, $classes);
        if ($toArray)
            return self::toArray($result);
        return $result;
    }

	private static function toArray($result)
	{
		$newResult = array();
		foreach($result as $record => $classes)
		{
			$row = array();
            foreach($classes as $class)
                foreach($class as $property => $value)
				    $row[$property] = $value;
			array_push($newResult, $row);
		}
		return $newResult;
	}

}
