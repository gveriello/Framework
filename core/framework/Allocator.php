<?php

class Allocator
{
    public static function allocate_helper($helper)
    {
        if ($helper !== '' && $helper !== null){
            allocate(HELPERS, $helper);
            return new $helper();
        }
        return null;
    }
    public static function allocate_library($library)
    {
        if ($library !== '' && $library !== null){
            allocate(LIBRARIES, $library);
            return new $library();
        }
        return null;
    }
    public static function allocate_css($css)
    {
        if ($css !== '' && $css !== null)
            if (filter_var($css, FILTER_VALIDATE_URL))
                return '<link rel="stylesheet" type="text/css" href="'.$css.'" >';
            else
                if (can_allocate(CSS, $css))
                    return '<link rel="stylesheet" type="text/css" href="'.string_for_allocate_file(CSS, $css).'" />';
        return '';
    }
    public static function allocate_js($js)
    {
        if ($js !== '' && $js !== null)
            if (filter_var($js, FILTER_VALIDATE_URL))
                return '<script src="'.$js.'" ></script>';
            else
                if (can_allocate(JS, $js))
                    return '<script src="'.string_for_allocate_file(JS, $js).'" ></script>';

        return '';
    }
}