<?php
class IndexPHP extends PHPBehind
{

    private $ViewBag;
    private $ViewTable;
    private $APIService;
    private $FormHelper;

    function __construct()
    {
        $this->ViewBag =    Allocator::allocate_helper('ViewBag');
        $this->ViewTable =  Allocator::allocate_helper('ViewTable');
        $this->APIService = Allocator::allocate_helper('APIService');
        $this->FormHelper = Allocator::allocate_helper('FormHelper');
    }
    function __destruct(){}

    public function index()
    {
        $this->APIService::SetCall("TestService", "getNomeCognome");
        $response = $this->APIService::run();

        $this->ViewBag::Add(null, parent::getModel());
        $this->ViewBag::Add('title', parent::getPage());
        $this->ViewBag::Add('response', $response);

        $this->ViewTable::SetStyle('column', 'a', 'font-size:20px;');
        $this->ViewTable::AddColumn('a,c,e');
        $this->ViewTable::AddData(parent::getModel()->arrayoftable);
        $this->ViewTable::DataBinding();

        $this->ViewBag::Add('table', $this->ViewTable::TableToHtml());

        $this->FormHelper::set_rules('bho', 'minlength', '', '2');
        $this->FormHelper::set_rules('bho', 'required', 'Il nome e\' obbligatorio');
        $this->FormHelper::set_rules('bho', 'matches', 'Le due password devono combaciare', 'bho2');
        $this->FormHelper::set_rules('bho', 'trim');
        $this->ViewBag::Add('validator', $this->FormHelper::validator());
        allocate(LAYOUT, parent::getLayout(), $this->ViewBag::getBag());
    }

    public function login()
    {
        $ViewBag = new ViewBag();
        $ViewBag::Add('error', 'credenziali errate');

        allocate(LAYOUT, parent::getLayout(), $ViewBag::getBag());
    }

    public function cosimo()
    {
        $result = validate_fields();
        $ViewBag = new ViewBag();
        $ViewBag::Add('error', implode("<br>", $result["message"]));
        allocate(LAYOUT, parent::getLayout(), $ViewBag::getBag());

    }
}