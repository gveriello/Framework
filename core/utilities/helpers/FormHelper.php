<?php

class FormHelper
{
    static private $ControlRules = array(
        'configurator' => array(),
        'token' => ''
        );
    public static function set_rules($_formcontrol, $_rules, $_message = '', $_comparator = '')
    {
        if (!empty($_comparator)) $_comparator = '['.$_comparator.']';
        if (!array_key_exists($_formcontrol, self::$ControlRules['configurator'])) self::$ControlRules['configurator'][$_formcontrol] = array();
        array_push(self::$ControlRules['configurator'][$_formcontrol],  $_rules.$_comparator.','.$_message);
        self::$ControlRules['token'] = base64_encode(password_hash(json_encode(self::$ControlRules['configurator']), PASSWORD_BCRYPT, ["cost" => 12]));
    }

    public static function validator()
    {
        return '<input type="hidden" name="formattributevalidator" value="'.base64_encode(json_encode(self::$ControlRules)).'" />';
    }

    public static function set_control_value($content = '<input type="text" name="bho" id="bho" value="" binding="ciao" />')
    {
        // a new dom object
        $dom = new DOMDocument;

        // load the html into the object
        $dom->loadHTML($content);
         // discard white space
        $dom->preserveWhiteSpace = false;
        $val = $dom->getElementById('bho');
    }

}