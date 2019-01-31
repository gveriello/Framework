<?php
class IndexController extends Page
{

    private $ViewBag;
    private $ViewTable;
    private $APIService;
    private $FormHelper;
	private $OrmHelper;

    function __construct()
    {
        Allocator::AllocateHelper('ViewBag');
        Allocator::AllocateHelper('ViewTable');
        Allocator::AllocateHelper('Service');
        Allocator::AllocateHelper('Form');
        //Allocator::AllocateHelper('Orm');
		//global $dbconfigurator;
		//OrmHelper::InitializeORM($dbconfigurator);
		//OrmHelper::Connect();
    }

    function __destruct()
    {
        unset($ViewBag);
        unset($ViewTable);
        unset($APIService);
        unset($FormHelper);
        unset($OrmHelper);
    }

    public function index()
    {
        $this->PHPBehavior->CreateTable();
        $this->PHPBehavior->ManageViewBag();
        $this->PHPBehavior->SetBhoRule();

        Allocator::AllocateLayout($this->Layout);
    }
}