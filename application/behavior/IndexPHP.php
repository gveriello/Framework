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

    public function CreateTable1()
    {
        ViewTableHelper::ConfigurationFromLayout($this->Layout, 'tableHelper');
        ViewTableHelper::AddData($this->Model->table);
        ViewTableHelper::DataBinding();
        ViewBagHelper::Add('table', ViewTableHelper::TableToHtml());
    }
    public function CreateTable2()
    {
        ViewTableHelper::AddColumn('Id');
        ViewTableHelper::AddColumn('Nome_device');
        ViewTableHelper::AddData($this->Model->table);
        ViewTableHelper::DataBinding();
        ViewBagHelper::Add('table', ViewTableHelper::TableToHtml());
    }

    public function ManageViewBag()
    {
        ViewBagHelper::AddObject($this->Model);
        ViewBagHelper::Add('title', $this->PageName);
        ViewBagHelper::Add('response', $this->CallService());
    }

    private function CallService()
    {
        ServiceHelper::InitializeCall("TestService", "getNomeCognome");
        return ServiceHelper::Run()['Exception'];
    }

    public function SetBhoRule()
    {
        FormHelper::AddRule('bho', 'minlength', '', '2');
        FormHelper::AddRule('bho', 'required', 'Il nome e\' obbligatorio');
        FormHelper::AddRule('bho', 'matches', 'Le due password devono combaciare', 'bho2');
        FormHelper::AddRule('bho', 'trim');
        ViewBagHelper::Add('validator', FormHelper::GetValidator());
    }
}