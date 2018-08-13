<?php
class IndexPHP extends PHPBehind
{
    private $ViewBag;
    private $ViewTable;
    private $APIService;
    private $FormHelper;
    function __construct()
    {
        $helper = new FrameworksHelper();
        $this->ViewBag = $helper->AllocateHelper('ViewBag');
        $this->ViewTable = $helper->AllocateHelper('ViewTable');
        $this->APIService = $helper->AllocateHelper('APIService');
        $this->FormHelper = $helper->AllocateHelper('FormHelper');
    }
    function __destruct(){}

    public function index()
    {
        $this->APIService->SetCall("TestService", "getNomeCognome");
        $response = $this->APIService->run();

        $this->ViewBag->Add(null, parent::getModel());
        $this->ViewBag->Add('title', parent::getPage());
        $this->ViewBag->Add('response', $response);

        $this->ViewTable->SetStyle('column', 'a', 'font-size:20px;');
        $this->ViewTable->AddColumn('a,c,e');
        $this->ViewTable->AddData(parent::getModel()->arrayoftable);
        $this->ViewTable->DataBinding();

        $this->ViewBag->Add('table', $this->ViewTable->TableToHtml());

        $this->FormHelper->SetRules('bho', 'minlength', 'Il nome deve avere almeno 2 caratteri', '2');
        $this->FormHelper->SetRules('bho', 'required', 'Il nome e\' obbligatorio');
        $this->ViewBag->Add('validator', $this->FormHelper->Validator());
        Allocate(LAYOUT, parent::getLayout(), $this->ViewBag->getBag());
    }

    public function login()
    {
        $ViewBag = new ViewBag();
        $ViewBag->Add('error', 'credenziali errate');

        Allocate(LAYOUT, parent::getLayout(), $ViewBag->getBag());
    }

    public function cosimo()
    {
        $result = ValidateField();
        $ViewBag = new ViewBag();
        $ViewBag->Add('error', implode("<br>", $result["message"]));
        Allocate(LAYOUT, parent::getLayout(), $ViewBag->getBag());
    }
}