<?php

class FormHelper
{
    private $ControlRules = array(
        'configurator' => array(),
        'token' => ''
        );
    public function __construct(){}
    public function SetRules($_formcontrol, $_rules, $_message = '', $_comparator = '')
    {
        if (!empty($_comparator)) $_comparator = '['.$_comparator.']';
        if (!array_key_exists($_formcontrol, $this->ControlRules['configurator'])) $this->ControlRules['configurator'][$_formcontrol] = array();
        array_push($this->ControlRules['configurator'][$_formcontrol],  $_rules.$_comparator.','.$_message);
        $this->ControlRules['token'] = base64_encode(password_hash(json_encode($this->ControlRules['configurator']), PASSWORD_BCRYPT, ["cost" => 12]));
    }
    public function Validator()
    {
        return '<input type="hidden" name="formattributevalidator" value="'.base64_encode(json_encode($this->ControlRules)).'" />';
    }
}