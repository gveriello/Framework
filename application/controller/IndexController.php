<?php
class IndexController extends Page
{
    function __construct()
    {
    }
    function __destruct(){}

    public function index()
    {
        Allocator::allocate_layout(parent::getLayout());
    }
}