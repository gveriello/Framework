<?php
#region JULIUS INITIALIZE

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * File allocator
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 */

// Allocate required pages indicated in Config.php

foreach ($autoloader as $folder => $requiredpages)
{
    foreach ($requiredpages as $page)
    {
        if (file_exists(string_for_allocate_file($folder, $page)))
        {
            require_once string_for_allocate_file($folder, $page);
        }
    }
}

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Calling Framework functions
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */
set_reporting();
remove_magic_quotes();
unregister_globals();

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * GO!
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

$url = ltrim(request_uri(), '/');
$url = rtrim($url, '/');
get_routing($url, $page, $action, $querystring, $phpbehind, $jsbehind, $layout, $model);
if (can_allocate(LAYOUT, $layout))
{
    if (can_allocate(MODEL, $model))
    {
        if (can_allocate(PHPBEHIND, $phpbehind))
        {
            allocate(JSBEHIND, $jsbehind);
            allocate(MODEL, $model);
            allocate(PHPBEHIND, $phpbehind);
            $dispatch = new $phpbehind();
            $GLOBALS = array(
                'page' => $page,
                'phpbehind' => $dispatch,
                'jsbehind' => $jsbehind,
                'layout' => $layout,
                'model' => new $model(),
                'action' => $action,
                'querystring' => $querystring
            );
            if ((int)method_exists($dispatch, $action))
                call_user_func_array(array($dispatch, $action), array());
            else
                show_404();
        }else
            show_404();
    }else
        show_404();
}else
    show_404();


#endregion