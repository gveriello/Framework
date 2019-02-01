<?php

class FireStoreDocument {

    private static $fields = [];
    private static $name = null;
    private static $createTime = null;
    private static $updateTime = null;

    public static function Initialize($json=null) 
    {
        if ($json !== null) {
            $data = json_decode($json, true, 16);
            // Meta properties
            self::$name = $data['name'];
            self::$createTime = $data['createTime'];
            self::$updateTime = $data['updateTime'];
            // Fields
            foreach ($data['fields'] as $fieldName => $value) {
                self::$fields[$fieldName] = $value;
            }
        }
    }

    public static function GetName() 
    {
        return self::$name;
    }

    public static function SetString($fieldName, $value) {
        self::$fields[$fieldName] = [
            'stringValue' => $value
        ];
    }

    public static function SetDouble($fieldName, $value) {
        self::$fields[$fieldName] = [
            'doubleValue' => floatval($value)
        ];
    }

    public static function SetArray($fieldName, $value) {
        self::$fields[$fieldName] = [
            'arrayValue' => $value
        ];
    }

    public static function SetBoolean($fieldName, $value) {
        self::$fields[$fieldName] = [
            'booleanValue' => !!$value
        ];
    }

    public static function SetInteger($fieldName, $value) {
        self::$fields[$fieldName] = [
            'integerValue' => intval($value)
        ];
    }

    public static function GetValueByFieldName($fieldName) {
        if (array_key_exists($fieldName, self::$fields)) {
            return reset(self::$fields[$fieldName]);
        }
        else return $fieldName. 'not found';
    }

    public static function ToJson() {
        return json_encode([
            'fields' => self::$fields
        ]);
    }

}