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
        'email'     => FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL
    ]);
    if ($user = first('SELECT * FROM users WHERE email = ? LIMIT 1', ...array_values($args))) {
        $password = filter_input(INPUT_POST, 'password');
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return header('Location: /');
        }
    }
    header('Location: /auth/login');
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
