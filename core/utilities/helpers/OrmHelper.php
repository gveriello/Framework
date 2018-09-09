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

    private static function sqlBuilder($class, $toArray = false, $condition = NULL)
    {
        //INITIALIZE
        $classTemp = new $class();
        $query = 'SELECT <fields> FROM <table> WHERE <condition>';

        //SET SELECT
        $fields = array();
        foreach($classTemp as $property => $value)
            array_push($fields, $class.'.'.$property);
        $fields = implode(', ', $fields);
        $query = str_replace('<fields>', $fields, $query);

        //SET FROM
        $query = str_replace('<table>', get_class($classTemp), $query);

        //SET WHERE
        if (empty($condition))
            $query = str_replace('WHERE <condition>', '', $query);
        if (!empty($condition))
            $query = str_replace('<condition>', $condition, $query);

        //FINALIZE
        $query = trim($query);

        //EXECUTE
        $result = self::executeQuery($query, $class);
		if ($toArray)
			return self::resultToArray($result);
		return $result;
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

    private function addWhereCondition($field, WHERE_KEY $key, $comparator, OPERATOR_KEY $operator = NULL)
    {
        $whereTemp = array();

        if ($key === NULL || empty($field) || empty($comparator))
            return false;

        if ($key !== NULL)
            array_push($whereTemp, $field, $key);

        if ($key === WHERE_KEY::EQUAL ||
            $key === WHERE_KEY::NOT_EQUAL ||
            $key === WHERE_KEY::GREATER_THAN ||
            $key === WHERE_KEY::LESS_THAN ||
            $key === WHERE_KEY::GREATER_THAN_OR_EQUAL ||
            $key === WHERE_KEY::LESS_THAN_OR_EQUAL)
            array_push($whereTemp,  $comparator);

        if ($key === WHERE_KEY::BETWEEN || $key === WHERE_KEY::NOT_BETWEEN)
            if (is_array($comparator))
                array_push($whereTemp, $comparator[0], OPERATOR_KEY::AND_KEY, $comparator[1]);

        if ($key === WHERE_KEY::IN || $key === WHERE_KEY::NOT_IN)
            if (is_array($comparator))
                array_push($whereTemp, '(', implode(',', $comparator), ')');

        if ($operator != NULL)
            array_push($whereTemp, $operator);

        self::$whereConditions .= implode(' ', $whereTemp);
        return true;
    }

    public static function getTable($class, $toArray = false)
    {
        if (!class_exists($class))
            throw new Exception("Classresult must be a name of class");

        return self::sqlBuilder($class, $toArray);
    }

    public static function getRow($class, $toArray = false, $property, WHERE_KEY $key, $value)
    {
        if (!class_exists($class))
            throw new Exception("Classresult must be a name of class");

        if (empty($property) || empty($value) || empty($key))
            throw new Exception("Property, Key, Value are required");

        return self::sqlBuilder($class, $toArray, self::addWhereCondition($property, $key, $value));
    }

    public static function queryByString($class, $query, $toArray = false)
    {
        $result = self::executeQuery($query, $class);
		if ($toArray)
			return self::resultToArray($result);
		return $result;
    }
}
