<?php

class SqlHelper
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

    public function addWhereCondition($field, WHERE_KEY $key, $comparator, OPERATOR_KEY $operator = NULL)
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
}