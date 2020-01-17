<?php

/**
 * Create a new User
 */
function createNewUser($conn)
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
        $is = create($conn, 'users', [
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'username'  => $username
        ]);
        if ($is) {
            history('info', 'Auth::register:: Successful', [ $email ]);
            return header("Location: /login.php");
        }
    }
    history('info', 'Auth::register:: Failed', [ $email ]);
    return header("Location: /user/register.php");
}

/**
 * Update User informations (PATCH)
 */
function updateUser($conn, $user)
{
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
        $is = patch($conn, 'users', $user['id'], [
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'username'  => $username,
        ]);
        if ($is) {
            history('info', "Auth::update:: Successful", [ $email ]);
            destroySession();
            return header('Location: /login.php');
        }
    }
    history('info', "Auth::update:: Failed", [ $email ]);
    return header("Location: /user/update.php");
}
