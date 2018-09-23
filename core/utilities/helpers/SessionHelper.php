<?php

class SessionHelper
{
    public static function start($https = false, $sessionName = 'julius_session')
    {
        ini_set('session.use_only_cookies', 1);
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $https, true);
        self::setSessionName($sessionName);
        self::regenerateSession();
        session_start();
    }

    public static function stop()
    {
        if (session_start())
            session_destroy();
    }

    public static function getValue($key)
    {
        if (session_start())
            return $_SESSION[$key];
    }

    public static function setValue($key, $value)
    {
        if (session_start())
            $_SESSION[$key] = $value;
    }

    public static function removeKey($key)
    {
        if (session_start())
            unset($_SESSION[$key]);
    }

    public static function getSessionName()
    {
        return session_name();
    }

    public static function setSessionName($name = 'julius_session')
    {
        session_name($name);
    }

    public static function regenerateSession()
    {
        session_regenerate_id();
    }

}