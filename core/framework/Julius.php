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
                    if (is_dir(PathFileToAllocate($folder, $value)))
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
        if (is_dir(PathFileToAllocate($folder, $page)))
        {
            $files = scandir(PathFileToAllocate($folder, $page));
            foreach($files as $file)
                if ($file !== '.' && $file !== '..' && $file != '.htaccess')
                    require_once PathFileToAllocate(PathFileToAllocate($folder, $page), $file);
        }else{
            if (file_exists(PathFileToAllocate($folder, $page)))
                require_once PathFileToAllocate($folder, $page);
        }

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Calling Framework functions
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

SetReporting();
RemoveMagicQuotes();
UnregisterGlobals();

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * GO!
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

$url = ltrim(RequestUri(), '/');
$url = rtrim($url, '/');
InitializeRouting($url, $page, $action, $querystring, $controller, $jsbehind, $layout, $model, $behavior);
if (CanAllocate(CONTROLLER, $controller))
{
    $behaviorInstance = Allocator::AllocatePHPBehavior($behavior);

    if (!is_null($behaviorInstance))
    {
        if (!is_subclass_of($behaviorInstance, 'Page'))
            throw new Exception("PHPBehavior must be extend Page");

        foreach(get_class_methods(IEvent) as $method)
            if ((int)method_exists($behaviorInstance, $method))
                Event::EventListen($method, $behaviorInstance->$method());
    }

    $controllerInstance = Allocator::AllocateController($controller);
    if (!is_subclass_of($controllerInstance, 'Page'))
        throw new Exception("Controller must be extend Page");

    $modelInstance = Allocator::AllocateModel($model);
    Allocator::AllocateJSBehavior($jsbehind);
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

    InitializePageByInstance($controllerInstance);
    InitializePageByInstance($behaviorInstance);

    if ((int)method_exists($controllerInstance, $action))
    {
        Event::EventTrigger('OnLoad');
        global $startExecution;
        call_user_func_array(array($controllerInstance, $action), array());
        $stopExecution = microtime();
        if ($showTimeExecution)
            echo $stopExecution - $startExecution;
    }
    else
        Show404();
}else
    Show404();
#endregion