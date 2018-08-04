<?php
class IndexPHP extends PHPBehind{
    private $ViewBag;
    private $ViewTable;
    function __construct(){
        $helper = new FrameworksHelper();
        $this->ViewBag = $helper->AllocateHelper('ViewBag');
        $this->ViewTable = $helper->AllocateHelper('ViewTable');
    }
    function __destruct(){}

    public function index()
    {
        $this->ViewBag->Add(null, parent::getModel());
        $this->ViewBag->Add('title', parent::getPage());
        $this->ViewTable->AddColumn('a');
        $this->ViewTable->AddColumn('c');
        $this->ViewTable->AddColumn('e');
        $this->ViewTable->AddData(parent::getModel()->arrayoftable);
        $this->ViewTable->DataBinding();
        $this->ViewBag->Add('table', $this->ViewTable->TableToHtml());
        Allocate(LAYOUT, parent::getLayout(), $this->ViewBag->getBag());
    }

    public function login()
    {
        $ViewBag = new ViewBag();
        $ViewBag->Add('error', 'credenziali errate');
        Allocate(LAYOUT, parent::getLayout(), $ViewBag->getBag());
    }



}