<?php
#region JULIUS INITIALIZE

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * File allocator
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 */

// Allocate required pages indicated in Config.php

foreach ($autoloader as $folder => $requiredpage)
{
    //preparo i file e le cartelle da aggiungere
    if (!is_array($requiredpage))
    {
        $cdir = scandir($folder);
        if (count($cdir) > 0)
        {
            $autoloader[$folder] = array();
            foreach ($cdir as $key => $value)
                if (!in_array($value,array(".","..")))
                    if (is_dir(string_for_allocate_file($folder, $value)))
                        array_push($autoloader[$folder], $value);
                    else
                        array_push($autoloader[$folder], pathinfo($value, PATHINFO_FILENAME));
        }
    }
    if (count($autoloader[$folder]) === 0)
        unset($autoloader[$folder]);
}

//aggiungo le risorse
foreach ($autoloader as $folder => $requiredpage)
    foreach ($requiredpage as $page)
        if (is_dir(string_for_allocate_file($folder, $page)))
        {
            $files = scandir(string_for_allocate_file($folder, $page));
            foreach($files as $file)
                if ($file !== '.' && $file !== '..')
                    require_once string_for_allocate_file(string_for_allocate_file($folder, $page), $file);
        }else{
            if (file_exists(string_for_allocate_file($folder, $page)))
                require_once string_for_allocate_file($folder, $page);
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
    if (can_allocate(MODEL, $model))
        if (can_allocate(PHPBEHIND, $phpbehind))
        {
            Allocator::allocate_model($model);
            Allocator::allocate_phpbehind($phpbehind);
            Allocator::allocate_jsbehind($jsbehind);
            $dispatch = new $phpbehind();
            $GLOBALS = array(
                'page' => $page,
                'phpbehind' => Allocator::allocate_phpbehind($phpbehind),
                'jsbehind' => $jsbehind,
                'layout' => $layout,
                'model' => Allocator::allocate_model($model),
                'action' => $action,
                'querystring' => $querystring
            );
            if ((int)method_exists($dispatch, $action))
                call_user_func_array(array($dispatch, $action), array());
            else
                show_404();
        }else
            show_404();
    else
        show_404();
else
    show_404();
#endregion