<?php

/**
 * View
 *
 * @param string $view
 * @param array $vars
 *
 * @return mixed
 */
function view($view, $vars = [])
{
    foreach ($vars as $name => $value) {
        $$name = $value;
    }
    return require_once dirname(__DIR__) . '/views/layouts/app.php';
}

/**
 * is Owner
 *
 * @param int $id
 *
 * @return bool
 */
function owner($id)
{
    [ 'user_id' => $userId ] = current(rows('SELECT * FROM posts WHERE id = ? LIMIT 1', $id));
    if (array_key_exists('user', $_SESSION)) {
        return $userId == $_SESSION['user']['id'];
    }
    return false;
}

/**
 * CSRF_TOKEN
 *
 * @param array $guards
 *
 * @return bool
 */
function verify($guards)
{
    foreach ($guards as [ $path, $method ]) {
        if ($_SERVER['SCRIPT_NAME'] == $path && $_SERVER['REQUEST_METHOD'] == $method) {
            $token = filter_var($_REQUEST['token'], FILTER_SANITIZE_STRING);
            if (hash_equals($token, $_SESSION['CSRF_TOKEN'])) {
                return true;
            }
            return false;
        }
    }
    return true;
}

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
                return true;
            }
            return false;
        }
    }
    return true;
}
