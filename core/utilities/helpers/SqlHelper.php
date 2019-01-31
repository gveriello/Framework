<?php

class SqlHelper
{
    private static $selectFields = array();
    private static $fromTables = array();
    private static $whereConditions = array();
    private static $limitSearch = '';
    private static $groupByFields = array();
    private static $orderByFields = array();
    private static $havingByConditions = array();

    #region SELECT METHODS

    public function AddSelectFieldsByArray($fields = array())
    {
        if (count($fields) === 0)
            return false;

        foreach($fields as $field)
            array_push(self::$selectFields, $field);
        return true;
    }

    public function AddSelectFieldsByString($fields, $delimeter = ';')
    {
        return self::AddSelectFieldsByArray(explode($delimeter, $fields));
    }

    public function ModifySelectFieldsByString($oldField, $newField)
    {
        if (empty($oldField) || empty($newField))
            return false;

        if (!empty($oldField) && !empty($newField) && in_array($oldField, self::$selectFields))
            self::$selectFields[$oldField] = $newField;
        return true;
    }

    public function RemoveSelectFieldsByArray($fields = array())
    {
        if (count($fields) === 0)
            return false;

        foreach($fields as $field)
            if(in_array($field, self::$selectFields))
                unset(self::$selectFields[$field]);

        return true;
    }

    public function RemoveSelectFieldsByString($fields, $delimeter = ';')
    {
        return self::RemoveSelectFieldsByArray(explode($delimeter, $fields));
    }
    #endregion

    #region FROM METHODS
    public function AddFromTablesByArray($tables = array())
    {
        if (count($tables) === 0)
            return false;

        foreach($tables as $table)
            array_push(self::$fromTables, $table);
        return true;
    }

    public function AddFromTablesByString($tables, $delimeter = ';')
    {
        return self::AddFromTablesByArray(explode($delimeter, $tables));
    }
    #endregion

    #region WHERE METHODS
    public function AddWhereCondition($property, $whereCondition, $value = '', $finalKey = '')
    {
        if (empty($property) && empty($whereCondition))
            return false;

        if (empty($whereCondition) || empty($property))
            return false;

        array_push(self::$whereConditions, $property, $whereCondition);

        if ($whereCondition === WHERE_KEY::EQUAL ||
            $whereCondition === WHERE_KEY::NOT_EQUAL ||
            $whereCondition === WHERE_KEY::GREATER_THAN ||
            $whereCondition === WHERE_KEY::LESS_THAN ||
            $whereCondition === WHERE_KEY::GREATER_THAN_OR_EQUAL ||
            $whereCondition === WHERE_KEY::LESS_THAN_OR_EQUAL)
            array_push(self::$whereConditions,  $value);

        if ($whereCondition === WHERE_KEY::BETWEEN || $whereCondition === WHERE_KEY::NOT_BETWEEN)
            if (is_array($value))
                if (count($value) === 2)
                    array_push(self::$whereConditions, $value[0], OPERATOR_KEY::AND_KEY, $value[1]);
                else
                    return false;

        if ($whereCondition === WHERE_KEY::IN || $whereCondition === WHERE_KEY::NOT_IN)
            if (is_array($value))
                array_push(self::$whereConditions, '(', implode(',', $value), ')');
            else
                return false;

        array_push(self::$whereConditions, $finalKey);

        return true;
    }
    #endregion

    #region ADDITIONAL METHODS
    public function ConfigQueryByClasses($classes = array())
    {
        foreach($classes as $class)
        {
            if (!class_exists($class))
                throw new Exception("Parameter must be a name of class");

            $class = new $class();
            self::AddFromTablesByString(get_class($class));

            foreach($class as $property => $value)
                self::AddSelectFieldsByString(get_class($class).'.'.$property);
        }
    }

    public function setLimit($limits = array())
    {
        if (count($limits) != 2)
            return false;

        self::$limitSearch = implode(", ", $limits);
        return true;
    }

    public function getSQL()
    {
        return
            trim(
            'SELECT '.(implode(',', self::$selectFields))
            .' FROM '.(implode(',', self::$fromTables))
            .((count(self::$whereConditions) > 0 ? ' WHERE '.(implode(' ', self::$whereConditions)) : ''))
            .((!empty(self::$orderByFields) ? ' ORDER BY '.self::$orderByFields : ''))
            .((!empty(self::$groupByFields) ? ' GROUP BY '.self::$groupByFields : ''))
            .((!empty(self::$havingByConditions) ? ' HAVING BY '.self::$havingByConditions : ''))
            .((!empty(self::$limitSearch) ? ' LIMIT '.self::$limitSearch : '')))
            .';';
    }

    public function Clear()
    {
        self::$selectFields = array();
        self::$fromTables = array();
        self::$whereConditions = array();
        self::$limitSearch = '';
        self::$groupByFields = array();
        self::$orderByFields = array();
        self::$havingByConditions = array();
    }
    #endregion
}