<?php

class IndexPHP extends Page implements IEvent
{
    public function OnControllerLoaded()
    {
    }
    public function OnLayoutBinded()
    {
    }
    public function OnPreRender()
    {
    }
    public function OnLoad()
    {
    }
    public function CreateTable()
    {
    }
    public function QueryToDB()
    {
        Allocator::allocate_helper('Sql');
        Allocator::allocate_helper('Orm');
        SqlHelper::configQueryByClasses(array(Device, Cell));
        SqlHelper::addWhereCondition("Device.Id", WHERE_KEY::EQUAL, "Cell.IdDevice");
        return OrmHelper::executeQueryByString(SqlHelper::getSQL(), array(Device, Cell), true);
    }
}