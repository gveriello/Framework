<?php
class APILibraries
{
    private $result;
    private $action;
    private $params;
    function __construct($_action, $_params)
    {
        if (!empty($_action))
        {
            $this->action = $_action;
            $this->params = $_params;
            $this->result = array(
                "NameAction" => $this->action,
                "Status" => "",
                "Message" => "",
                "RequestStart" => microtime(true),
                "RequestEnd" => "",
                "TimeExecution" => ""
                );
            call_user_func(array($this, $this->action));
        }
    }
    function setResult($_result, $_status)
    {
        $this->result["RequestEnd"] = microtime(true);
        $this->result["TimeExecution"] = $this->result["RequestStart"] - $this->result["RequestEnd"];
        $this->result["Message"] = $_result;
        $this->result["Status"] = $_status;
    }
    function GenerateReport()
    {
        $Report = array();
        $Report["CallTime"] = array(
            "TimeExecution" => $this->result["TimeExecution"]
            );
        $Report["CallResponse"] = array(
            "NameAction" => $this->result["NameAction"],
            "Status" => $this->result["Status"],
            "Message" => $this->result["Message"]
            );
        return json_encode($Report);
    }
}