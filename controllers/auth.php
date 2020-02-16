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
    $args = filter_input_array(INPUT_POST, [
        'email'     => FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL
    ]);
    if ($user = rows('SELECT * FROM users WHERE email = ? LIMIT 1', ...array_values($args))) {
        $user = current($user);

        $password = filter_input(INPUT_POST, 'password');
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return header('Location: /');
        }
    }
    return header('Location: /auth/login.php');
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
