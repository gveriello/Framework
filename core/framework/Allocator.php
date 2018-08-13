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
}