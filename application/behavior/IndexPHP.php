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

    public function CreateTable()
    {
        ViewTableHelper::ConfigurationFromLayout($this->Layout, 'tableHelper');
        ViewTableHelper::AddData($this->Model->table);
        ViewTableHelper::DataBinding();
    }

    public function ManageViewBag()
    {
        ServiceHelper::InitializeCall("TestService", "getNomeCognome");
        $response = ServiceHelper::Run()['Exception'];
        ViewBagHelper::AddObject($this->Model);
        ViewBagHelper::Add('title', $this->PageName);
        ViewBagHelper::Add('response', $response);
        ViewBagHelper::Add('validator', FormHelper::GetValidator());
        ViewBagHelper::Add('table', ViewTableHelper::TableToHtml());
    }

    public function SetBhoRule()
    {
        FormHelper::AddRule('bho', 'minlength', '', '2');
        FormHelper::AddRule('bho', 'required', 'Il nome e\' obbligatorio');
        FormHelper::AddRule('bho', 'matches', 'Le due password devono combaciare', 'bho2');
        FormHelper::AddRule('bho', 'trim');
    }
}