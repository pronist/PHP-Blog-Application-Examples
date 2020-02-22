<?php

/**
 * Register Form for a new User (GET)
 */
function showRegisterForm() // create
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
    return __user(function ($args) {
        return go('INSERT INTO users(email, password, username) VALUES(?, ? ,?)', $args, '/auth/login');
    });
}

/**
 * Update Form for User informations (GET)
 */
function showUpdateForm() // edit
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
    return __user(function ($args) use ($id) {
        $args['id'] = $_SESSION['user']['id'];
        return go('UPDATE users SET email = ?, password = ?, username = ? WHERE id = ?', $args, '/auth/login');
    });
}

/**
 * @param callback $callback
 *
 * @return void
 */
function __user($callback)
{
    $args = filter_input_array(INPUT_POST, [
        'email'     => FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL,
        'password'  => FILTER_SANITIZE_STRING
    ]);
    $args['username'] = current(explode('@', $args['email']));
    $args['password'] = password_hash($args['password'], PASSWORD_DEFAULT);

    if (call_user_func($callback, $args)) {
        session_unset();
        return session_destroy();
    }
}
