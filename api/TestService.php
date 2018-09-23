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
        Allocator::allocate_helper('Sql');
        Allocator::allocate_helper('Orm');
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
        SqlHelper::configQueryByClasses(array(Device, Cell));
        SqlHelper::addWhereCondition("Device.Id", WHERE_KEY::EQUAL, "Cell.IdDevice");
        return OrmHelper::executeQueryByString(SqlHelper::getSQL(), array(Device, Cell), true);
    }
}