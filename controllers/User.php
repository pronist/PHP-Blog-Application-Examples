<?php

/**
 * Register Form for a new User (GET)
 */
function showRegisterForm()
{
    setSession('CSRF_TOKEN', getToken());

    return component('app-auth-form', [
        'token'         => getSession('CSRF_TOKEN'),
        'request_url'   => '/user'
    ]);
}

/**
 * Create a new User
 */
function createNewUser()
{
    [
        'email'         => $email,
        'password'      => $password,
        'token'         => $token
    ] = getParamsWithFilters([
        'params' => getInputParams('post'),
        'filterMappings' => [
            'email' => [
                FILTER_VALIDATE_EMAIL,
                FILTER_SANITIZE_EMAIL
            ]
        ]
    ]);
    if ($email & $password && verity($token, getSession('CSRF_TOKEN'))) {
        $username = current(explode('@', $email));
        $is = create('users', [
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'username'  => $username
        ]);
        if ($is) {
            history('info', 'Auth::register:: Successful', [ $email ]);
            return header("Location: /auth/login");
        }
    }
    history('info', 'Auth::register:: Failed', [ $email ]);
    return header("Location: /user/register");
}

/**
 * Update Form for User informations (GET)
 */
function showUserUpdateForm()
{
    setSession('CSRF_TOKEN', getToken());
    $user = user();

    [ 'email' => $email ] = get('users', 'first', [ 'wheres' => [ 'id' ] ], $user['id']);
    return component('app-auth-form', array_merge(
        compact('email'),
        [
            'token'         => getSession('CSRF_TOKEN'),
            'request_url'   => '/user',
            'method'        => 'patch'
        ]
    ));
}

/**
 * Update User informations (PATCH)
 */
function updateUser()
{
    $user = user();

    [
        'email'     => $email,
        'password'  => $password,
        'token'     => $token
    ] = getParamsWithFilters([
        'params' => getInputParams('patch'),
        'filterMappings' => [
            'email' => [
                FILTER_VALIDATE_EMAIL,
                FILTER_SANITIZE_EMAIL
            ]
        ]
    ]);

    if ($email && $password && verity($token, getSession('CSRF_TOKEN'))) {
        $username = current(explode('@', $email));
        $is = patch('users', $user['id'], [
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'username'  => $username,
        ]);
        if ($is) {
            history('info', "Auth::update:: Successful", [ $email ]);
            return header('Location: /');
        }
    }
    history('info', "Auth::update:: Failed", [ $email ]);
    return header("Location: /user/update");
}
