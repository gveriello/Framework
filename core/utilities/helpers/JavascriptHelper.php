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
    public static function allocate_jquery()
    {
        global $jquery_url;
        return Allocator::allocate_js($jquery_url);
    }
}