<?php

class Event
{
    private static $events = [];

    public static function EventListen($name, $callback)
    {
        self::$events[$name][] = $callback;
    }

    public static function EventTrigger($name, $argument = null)
    {
        foreach ((array)self::$events[$name] as $event => $callback)
            if($argument && is_array($argument))
                call_user_func_array($callback, $argument);
            elseif ($argument && !is_array($argument))
                call_user_func($callback, $argument);
            else
                call_user_func($callback);
    }
}