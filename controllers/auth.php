<?php

/**
 * Login Form for a User (GET)
 */
function showLoginForm()
{
    return view('auth', [
        'requestUrl' => '/auth/login.php'
    ]);
}

/**
 * Create a User Session (POST)
 */
function login()
{
    return auth('/', '/auth/login.php');
}

/**
 * Delete a User Session (POST)
 */
function logout()
{
    session_unset();
    session_destroy();

    return header('Location: /');
}
