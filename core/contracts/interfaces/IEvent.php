<?php

interface IEvent
{
    public function OnControllerLoaded();
    public function OnLayoutBinded();
    public function OnPreRender();
    public function OnLoad();
}
