<?php

/**
 * Update Form for User informations (GET)
 */
function showUserUpdateForm($conn, $user)
{
    setSession('CSRF_TOKEN', getToken());

    [ 'email' => $email ] = get(
        $conn,
        'users',
        'first',
        [
            'wheres' => [ 'id' ]
        ],
        $user['id']
    );
    return view('auth/form', array_merge(
        compact('email', 'user'),
        [
            'token'      => getSession('CSRF_TOKEN'),
            'requestUrl' => '/user/',
            'method'     => 'patch'
        ]
    ));
}
