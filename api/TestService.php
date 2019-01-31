<?php
class TestService
{
    function __construct()
    {
        Allocator::AllocateHelper('Sql');
        Allocator::AllocateHelper('Orm');
    }

    function getOperation()
    {
        return '';
    }

    function getNomeCognome()
    {
        return 'ok';
    }

    function getTableForTest()
    {
        SqlHelper::ConfigQueryByClasses(array(Device, Cell));
        SqlHelper::AddWhereCondition("Device.Id", WHERE_KEY::EQUAL, "Cell.IdDevice");
        return OrmHelper::ExecuteQueryByString(SqlHelper::getSQL(), array(Device, Cell), true);
    }
}