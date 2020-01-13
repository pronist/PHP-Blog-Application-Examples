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
    foreach ($methods as $method) {
        if (strtoupper($method) == getRequestMethod()) {
            $user = getSession('user');
            if ($user) {
                return $user;
            } else {
                header("Location: /login.php");
                return;
            }
        }
    }
    return true;
}
