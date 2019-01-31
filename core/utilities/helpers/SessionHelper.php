<?php

class SessionHelper
{
    public static $SessionName = session_name();

    public static function Start($https = false, $sessionName = 'julius_session')
    {
        ini_set('session.use_only_cookies', 1);
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $https, true);
        self::SetSessionName($sessionName);
        self::RegenerateSession();
        session_start();
    }

    public static function Stop()
    {
        if (session_start())
            session_destroy();
    }

    public static function GetValueByKey($key)
    {
        if (session_start())
            return $_SESSION[$key];
    }

    public static function SetValue($key, $value)
    {
        if (session_start())
            $_SESSION[$key] = $value;
    }

    public static function RemoveKey($key)
    {
        if (session_start())
            unset($_SESSION[$key]);
    }

    public static function SetSessionName($name = 'julius_session')
    {
        session_name($name);
    }

    public static function RegenerateSession()
    {
        session_regenerate_id();
    }

}