<?php

/**
 * Guard
 *
 * @param array $methods
 *
 * @return bool|array
 */
function guard($methods)
{
    $request  = array_filter(
        $methods,
        function ($method) {
            return strtoupper($method) == getRequestMethod();
        }
    );
    if ($request) {
        if ($user = getSession('user')) {
            return $user;
        }
        header("Location: /login.php");
        return;
    }
    return true;
}
