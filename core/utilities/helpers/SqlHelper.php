<?php
class SqlSELECT
{
    private static $selectFields = '';
    private static $fromTables = '';
    private static $whereConditions = '';
    private static $limitSearch = array();
    private static $groupByFields = array();
    private static $orderByFields = array();
    private static $havingByConditions = array();

    public function addClassResults($classResults = array())
    {
        if (!class_exists($classResult))
            throw new Exception("Classresult must be a name of class");
        if (count($classResults) === 0)
            return false;

        $fromTemp = array();
        $selectTemp = array();
        foreach($classResults as $class)
        {
            $class = new $class();
            array_push($fromTemp, get_class($class));
            foreach($class as $property => $value)
                array_push($selectTemp, $class.'.'.$property);
        }

        self::$selectFields .= implode(',', $selectTemp);
        self::$fromTables .= implode(',', $fromTemp);
        return true;
    }

    

    public function addLimit($start, $stop = NULL)
    {
        self::$limitSearch = implode(", ", array($start, $stop));
    }
}
class SqlHelper
{

}