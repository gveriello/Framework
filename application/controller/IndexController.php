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
        Allocator::allocate_helper('ViewBag');
        Allocator::allocate_helper('ViewTable');
        Allocator::allocate_helper('Service');
        Allocator::allocate_helper('Form');
        Allocator::allocate_helper('Orm');
		global $dbconfigurator;
		OrmHelper::initialize($dbconfigurator);
		OrmHelper::connect();
    }
    function __destruct(){}

    public function index()
    {
        ServiceHelper::SetCall("TestService", "getNomeCognome", parent::getModel()->arrayoftable, 'ciao');
        $response = ServiceHelper::run()['Response'];
        ServiceHelper::SetCall("TestService", "getTableForTest");
        $table = ServiceHelper::run()['Response'];
        FormHelper::set_rules('bho', 'minlength', '', '2');
        FormHelper::set_rules('bho', 'required', 'Il nome e\' obbligatorio');
        FormHelper::set_rules('bho', 'matches', 'Le due password devono combaciare', 'bho2');
        FormHelper::set_rules('bho', 'trim');
        ViewTableHelper::SetStyle('column', 'Id', 'font-size:20px;');
        ViewTableHelper::AddColumn('Id,Nome_device,Modello_device,Nome_cell,Modello_cell');
        ViewTableHelper::AddData($table);
        ViewTableHelper::DataBinding();
        ViewBagHelper::AddModel(parent::getModel());
        ViewBagHelper::Add('title', parent::getPage());
        ViewBagHelper::Add('response', $response);
        ViewBagHelper::Add('validator', FormHelper::validator());
        ViewBagHelper::Add('table', ViewTableHelper::TableToHtml());
        Allocator::allocate_layout(parent::getLayout(), ViewBagHelper);
    }

    public function cosimo()
    {
        $result = validate_fields();
        $this->ViewBag::Add('error', implode("<br>", $result["message"]).'<br>');
        Allocator::allocate_layout(parent::getLayout(), $this->ViewBag);
    }
}