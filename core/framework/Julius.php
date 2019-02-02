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

//Allocate the resources
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
 * Initialize routing page
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

$url = ltrim(RequestUri(), '/');
$url = rtrim($url, '/');
InitializeRouting($url, $page, $action, $querystring, $controller, $jsbehind, $layout, $model, $behavior);

/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * Initialize controller, behavior, model & layout
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

$controllerInstance = null;
$behaviorInstance = null;
$modelInstance = null;

//if not possible to allocate controller
if (!CanAllocate(CONTROLLER, $controller))
{
    Show404();
    return;
}

$controllerInstance = Allocator::AllocateController($controller);
if (!is_subclass_of($controllerInstance, 'Page'))
    throw new Exception("Controller must be extend Page");

//if not exist method to call in controller
if (!method_exists($controllerInstance, $action))
{
    Show404();
    return;
}

if (CanAllocate(BEHAVIOR, $behavior))
{
    $behaviorInstance = Allocator::AllocatePHPBehavior($behavior);
    if (!is_subclass_of($behaviorInstance, 'Page'))
        throw new Exception("PHPBehavior must be extend Page");

    //Initialize listen for event
    foreach(get_class_methods(IEvent) as $method)
        if ((int)method_exists($behaviorInstance, $method))
            Event::EventListen($method, $behaviorInstance->$method());
}

if (CanAllocate(MODEL, $model))
    $modelInstance = Allocator::AllocateModel($model);

if (CanAllocate(JSBEHIND, $jsbehind))
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

Event::EventTrigger('OnLoad');
call_user_func_array(array($controllerInstance, $action), array());
global $startExecution;
if ($showTimeExecution)
    echo microtime(true) - $startExecution;
#endregion