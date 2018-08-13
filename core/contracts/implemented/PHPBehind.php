<?php
class PHPBehind extends Page{

    #region extension page's method
    protected function getPage(){
        return parent::getPage();
    }

    protected function getPHPBehind(){
        return parent::getPHPBehind();
    }

    protected function getJSBehind(){
        return parent::getJSBehind();
    }

    protected function getLayout(){
        return parent::getLayout();
    }

    protected function getModel(){
        return parent::getModel();
    }

    protected function getAction(){
        return parent::getAction();
    }

    protected function getQueryString(){
        return parent::getQueryString();
    }
    #endregion

    #region crypt and decrypt algorithm
    #endregion
}