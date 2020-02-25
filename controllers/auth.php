<?php

/**
 * Login Form for a User (GET)
 */
function showLoginForm()
{
    return view('auth', [
        'requestUrl' => '/auth/login'
    ]);
}

/**
 * Create a User Session (POST)
 */
function login()
{
    $args = filter_input_array(INPUT_POST, [
        'email'     => FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL,
        'password'  => FILTER_DEFAULT
    ]);

    if (__login(...array_values($args))) {
        return header('Location: /');
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}

/**
 * Delete a User Session (POST)
 */
function logout()
{
    __logout();
    return header('Location: /');
}
