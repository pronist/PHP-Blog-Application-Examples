<?php

/**
 * start Session
 *
 * @codeCoverageIgnore
 */
function startSession()
{
    list('save_path' => $savePath) = include dirname(__DIR__) . "/config/session.php";
    session_save_path($savePath);
    return session_start() ?: alert("Session:: Cannot start");
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
 * @return bool
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
 * @codeCoverageIgnore
 */
function destroySession()
{
    session_unset();
    session_destroy();
}
