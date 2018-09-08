<?php
class TestService
{
    private $action;
    private $params;
    private $result;
    function __construct(&$result, $_action, ...$_params)
    {
        $this->action = $_action;
        $this->params = $_params;
        $this->result = $result;
    }
    function getOperation()
    {
        return '';
    }
    function getNomeCognome()
    {
        return 'ok';
    }
}