<?php

/**
 * Register auth guard
 *
 * @param array $guards
 *
 * @return bool
 */
function guard($guards)
{
    foreach ($guards as $path) {
        if ($_SERVER['SCRIPT_NAME'] == $path) {
            if (array_key_exists('user', $_SESSION)) {
                continue;
            }
            return false;
        }
    }
    return true;
}

/**
 * login
 *
 * @param string $redirectOnSuccess
 * @param string $redirectOnFailure
 *
 * @return void
 */
function auth($redirectOnSuccess, $redirectOnFailure)
{
    return __auth($redirectOnSuccess, $redirectOnFailure, function ($args) {
        if (check($args)) {
            if ($user = current(rows('SELECT * FROM users WHERE email = ? LIMIT 1', $args['email']))) {
                if (password_verify($args['password'], $user['password'])) {
                    $_SESSION['user'] = $user;
                    return true;
                }
            }
        }
        return false;
    });
}
