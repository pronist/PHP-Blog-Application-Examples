<?php

/**
 * user
 *
 * @param string $query
 * @param string $redirectOnSuccess
 * @param string $redirectOnFailure
 * @param array $params
 *
 * @return void
 */
function user($query, $redirectOnSuccess, $redirectOnFailure, ...$params)
{
    return __auth($redirectOnSuccess, $redirectOnFailure, function ($args) use ($query, $params) {
        $args['username'] = current(explode('@', $args['email']));
        $args['password'] = password_hash($args['password'], PASSWORD_DEFAULT);

        $params = array_merge($args, $params);
        if (check($params) && execute($query, ...array_values($params))) {
            session_unset();
            session_destroy();
            return true;
        }
        return false;
    });
}

/**
 * Base codes for user, auth
 *
 * @param string $redirectOnSuccess
 * @param string $redirectOnFailure
 * @param callback $callback
 *
 * @return void
 */
function __auth($redirectOnSuccess, $redirectOnFailure, $callback)
{
    $args = filter_input_array(INPUT_POST, [
        'email' => FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL,
        'password' => FILTER_SANITIZE_STRING
    ]);
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

    if (hash_equals($token, $_SESSION['CSRF_TOKEN']) && call_user_func($callback, $args)) {
        return header('Location: ' . $redirectOnSuccess);
    }
    return header("Location: " . $redirectOnFailure);
}
