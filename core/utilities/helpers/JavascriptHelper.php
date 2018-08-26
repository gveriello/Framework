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

    public static function get_value($_controlname, $_attribute)
    {
        return '<script>$("#'.$_controlname.'").attr("'.$_attribute.'");</script>';
    }
    public static function set_value($_controlname, $_attribute, $_value)
    {
        echo '<script>eval($("#'.$_controlname.'").attr("'.$_attribute.'", "'.$_value.'"));</script>';
    }
}