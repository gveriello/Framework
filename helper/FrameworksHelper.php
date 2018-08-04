<?php

/**
 * FrameworksHelper short summary.
 *
 * FrameworksHelper description.
 *
 * @version 1.0
 * @author gveriello
 */
class FrameworksHelper
{
    function __construct(){}
    function AllocateHelper($HelperName){
        if ($HelperName !== '' && $HelperName !== null){
            Allocate(HELPER, $HelperName);
            return new $HelperName();
        }
        return null;
    }
}