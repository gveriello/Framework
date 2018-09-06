<?php

class IndexPHP implements IEvent
{
    public function OnControllerLoaded()
    {
        echo '<br>Controller Loaded';
    }
    public function OnLayoutBinded()
    {
        echo '<br>OnLayoutBind';
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