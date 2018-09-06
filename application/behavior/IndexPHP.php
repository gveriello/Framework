<?php

class IndexPHP implements IEvent
{
    public function OnControllerLoaded()
    {
        echo '<br>ControllerLoader';
    }
    public function OnLayoutBinded()
    {
        echo '<br>OnLayoutBinded';
    }
    public function OnPreRender()
    {
        echo '<br>OnPreRender';
    }
    public function OnLoad()
    {
        echo '<br>OnLoad';
    }
}