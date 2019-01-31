<?php

/**
 * JavascriptHelper short summary.
 *
 * JavascriptHelper description.
 *
 * @version 1.0
 * @author gveriello
 */
class JavascriptHelper
{
    public static function AllocateJQuery()
    {
        global $jquery_url;
        return Allocator::AllocateJS($jquery_url);
    }
}