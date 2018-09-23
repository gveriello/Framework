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
        $this->ViewBag          = Allocator::allocate_helper('ViewBag');
        $this->ViewTable        = Allocator::allocate_helper('ViewTable');
        $this->ServiceHelper    = Allocator::allocate_helper('Service');
        $this->FormHelper       = Allocator::allocate_helper('Form');
        $this->OrmHelper		= Allocator::allocate_helper('Orm');
		global $dbconfigurator;
		$this->OrmHelper::initialize($dbconfigurator);
		$this->OrmHelper::connect();
    }
    function __destruct(){}

    public function index()
    {
        $this->ServiceHelper::SetCall("TestService", "getNomeCognome", parent::getModel()->arrayoftable, 'ciao');
        $this->FormHelper::set_rules('bho', 'minlength', '', '2');
        $this->FormHelper::set_rules('bho', 'required', 'Il nome e\' obbligatorio');
        $this->FormHelper::set_rules('bho', 'matches', 'Le due password devono combaciare', 'bho2');
        $this->FormHelper::set_rules('bho', 'trim');
        $this->ViewBag::AddModel(parent::getModel());
        $this->ViewTable::SetStyle('column', 'Id', 'font-size:20px;');
        $this->ViewTable::AddColumn('Id,Nome_device,Modello_device,Nome_cell,Modello_cell');
        $this->ViewTable::AddData(parent::getBehavior()->QueryToDB());
        $this->ViewTable::DataBinding();
        $this->ViewBag::Add('title', parent::getPage());
        $this->ViewBag::Add('response', $this->ServiceHelper::run()['Response']);
        $this->ViewBag::Add('validator', $this->FormHelper::validator());
        $this->ViewBag::Add('table', $this->ViewTable::TableToHtml());
        Allocator::allocate_layout(parent::getLayout(), $this->ViewBag);
    }

    public function cosimo()
    {
        $result = validate_fields();
        $this->ViewBag::Add('error', implode("<br>", $result["message"]).'<br>');
        Allocator::allocate_layout(parent::getLayout(), $this->ViewBag);
    }
}