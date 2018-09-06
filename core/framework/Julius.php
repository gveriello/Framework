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
get_routing($url, $page, $action, $querystring, $controller, $jsbehind, $layout, $model, $behavior);
if (can_allocate(CONTROLLER, $controller))
{
    $behaviorInstance = Allocator::allocate_behavior($behavior);

    if (!is_null($behaviorInstance))
    {
        $methods_implemented = get_class_methods($behaviorInstance);
        foreach($methods_implemented as $method)
            if ((int)method_exists($behaviorInstance, $method))
                Event::listen($method, $behaviorInstance->$method());
    }
    $controllerInstance = Allocator::allocate_controller($controller);
    $modelInstance = Allocator::allocate_model($model);
    Allocator::allocate_jsbehind($jsbehind);
    $GLOBALS = array(
        'page' => $page,
        'phpbehind' => $controllerInstance,
        'model' => $modelInstance,
        'behavior' => $behaviorInstance,
        'jsbehind' => $jsbehind,
        'layout' => $layout,
        'action' => $action,
        'querystring' => $querystring
    );
    if ((int)method_exists($controllerInstance, $action))
    {
        Event::trigger('OnLoad');
        call_user_func_array(array($controllerInstance, $action), array());
    }
    else
        show_404();
}else
    show_404();
#endregion