<?php

/**
 * Login Form for a User (GET)
 */
function showLoginForm()
{
    setSession('CSRF_TOKEN', getToken());

    return component('app-auth-form', [
        'token'         => getSession('CSRF_TOKEN'),
        'request_url'   => '/auth/login'
    ]);
}

/**
 * Create a User Session (POST)
 */
function login()
{
    [
        'email'     => $email,
        'password'  => $password,
        'token'     => $token
    ] = getParamsWithFilters([
        'params' => getInputParams('post'),
        'filterMappings' => [
            'email' => [
                FILTER_VALIDATE_EMAIL,
                FILTER_SANITIZE_EMAIL
            ]
        ]
    ]);
    if ($email && $password && verity($token, getSession('CSRF_TOKEN'))) {
        $user = get('users', 'first', [ 'wheres' => [ 'email' ] ], $email);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                history('info', 'Auth::login:: Successful', [ $email ]);
                setSession('user', $user);
                return header('Location: /');
            }
        }
    }
    history('info', 'Auth::login:: Failed', [ $email ]);
    return header('Location: /auth/login');
}

/**
 * Delete a User Session (POST)
 */
function logout()
{
    return destroySession();
}
