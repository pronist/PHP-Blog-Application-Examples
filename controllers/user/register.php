<?php

/**
 * Register Form for a new User (GET)
 */
function showRegisterForm()
{
    setSession('CSRF_TOKEN', getToken());

    return view('auth/form', [
        'user'       => getSession('user'),
        'token'      => getSession('CSRF_TOKEN'),
        'requestUrl' => '/user/'
    ]);
}
