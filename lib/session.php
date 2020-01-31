<?php

/**
 * start Session
 *
 * @return void
 */
function startSession()
{
    [
        'lifetime'          => $lifetime,
        'cookie_lifetime'   => $cookieLifeTime
    ] = include dirname(__DIR__) . "/config/session.php";

    ini_set('session.gc_maxlietime', $lifetime);
    session_set_cookie_params($cookieLifeTime);

    [ 'session' => $session ] = include dirname(__DIR__) . "/config/storage.php";
    session_save_path($session);
    return session_start() ?: history('alert', "Session:: Cannot start");
}

/**
 * get Session with key
 *
 * @param string $key
 *
 * @return mixed|null
 */
function getSession($key)
{
    if (array_key_exists($key, $_SESSION)) {
        return $_SESSION[$key];
    }
    return null;
}

/**
 * set Session with key
 *
 * @param string $key
 * @param mixed $value
 *
 * @return mixed|bool
 */
function setSession($key, $value)
{
    if (isset($_SESSION)) {
        return $_SESSION[$key] = $value;
    }
    return false;
}

/**
 * remove Session with key
 *
 * @param string $key
 */
function removeSession($key)
{
    unset($_SESSION[$key]);
}

/**
 * destroy Session
 *
 * @return void
 */
function destroySession()
{
    session_unset();
    return session_destroy();
}
