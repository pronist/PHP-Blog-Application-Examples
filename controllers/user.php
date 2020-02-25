<?php

/**
 * Register Form for a new User (GET)
 */
function create()
{
    return view('auth', [
        'requestUrl' => '/user/register'
    ]);
}

/**
 * Create a new User (POST)
 */
function store()
{
    $args = filter_input_array(INPUT_POST, [
        'email'     => FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL,
        'password'  => FILTER_SANITIZE_STRING
    ]);
    $args['username'] = current(explode('@', $args['email']));
    $args['password'] = password_hash($args['password'], PASSWORD_DEFAULT);

    if (__storeUser(...array_values($args))) {
        __logout();
        return header('Location: /auth/login');
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}

/**
 * Update Form for User informations (GET)
 */
function edit()
{
    return view('auth', [
        'requestUrl' => '/user/update',
        'email'      => $_SESSION['user']['email']
    ]);
}

/**
 * Update User informations (POST)
 *
 * @param int $id
 */
function update()
{
    $args = filter_input_array(INPUT_POST, [
        'email'     => FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL,
        'password'  => FILTER_SANITIZE_STRING
    ]);
    $args['username'] = current(explode('@', $args['email']));
    $args['password'] = password_hash($args['password'], PASSWORD_DEFAULT);

    $args['id'] = $_SESSION['user']['id'];

    if (__updateUser(...array_values($args))) {
        __logout();
        return header('Location: /auth/login');
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}
