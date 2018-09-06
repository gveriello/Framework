<?php
class IndexController extends PagePHPBehind
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
        global $start;
        echo microtime(true) - $start;
        $this->APIService::SetCall("TestService", "getNomeCognome");
        $response = $this->APIService::run();
        {
            $this->ViewTable::SetStyle('column', 'a', 'font-size:20px;');
            $this->ViewTable::AddColumn('a,c,e');
            $this->ViewTable::AddData(parent::getModel()->arrayoftable);
            $this->ViewTable::DataBinding();
        }
        {
            $this->FormHelper::set_rules('bho', 'minlength', '', '2');
            $this->FormHelper::set_rules('bho', 'required', 'Il nome e\' obbligatorio');
            $this->FormHelper::set_rules('bho', 'matches', 'Le due password devono combaciare', 'bho2');
            $this->FormHelper::set_rules('bho', 'trim');
        }
        {
            $this->ViewBag::AddModel(parent::getModel());
            $this->ViewBag::Add('title', parent::getPage());
            $this->ViewBag::Add('response', $response);
            $this->ViewBag::Add('table', $this->ViewTable::TableToHtml());
            $this->ViewBag::Add('validator', $this->FormHelper::validator());
        }
        Allocator::allocate_layout(parent::getLayout(), $this->ViewBag);
        new a();
    }

    public function login()
    {
        $this->ViewBag::Add('error', 'credenziali errate');
        Allocator::allocate_layout(parent::getLayout(), $this->ViewBag::getBag());
    }

    public function cosimo()
    {
        $result = validate_fields();
        $this->ViewBag::Add('error', implode("<br>", $result["message"]).'<br>');
        Allocator::allocate_layout(parent::getLayout(), $this->ViewBag);
    }
}