<?php

/**
 * Login Form for a User (GET)
 */
function showLoginForm()
{
    setSession('CSRF_TOKEN', getToken());

    return view('auth/form', [
        'user'       => getSession('user'),
        'token'      => getSession('CSRF_TOKEN'),
        'requestUrl' => '/login.php'
    ]);
}

/**
 * Create a User Session (POST)
 */
function login($conn)
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
        $user = get($conn, 'users', 'first', [ 'wheres' => [ 'email' ] ], $email);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                history('info', 'Auth::login:: Successful', [ $email ]);
                setSession('user', $user);
                return header("Location: /");
            }
        }
    }
    history('info', 'Auth::login:: Failed', [ $email ]);
    return header("Location: /login.php");
}
