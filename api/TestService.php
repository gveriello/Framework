<?php
class TestService extends APILibraries
{
    function __construct($_action, $_params = array())
    {
        parent::__construct($_action, $_params);
    }
    function getOperation()
    {
        parent::setResult("ok");
    }
    function getNomeCognome(){
        parent::setResult("Giuseppe VEriello", true);
    }
}