<?php

require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

/**
 * Auth
 */
$user = guard([ 'GET' ]) ?? exit;

switch (getRequestMethod()) {
    case 'GET':
        setSession('CSRF_TOKEN', getToken());
        list(
            'email' => $email
        ) = first($conn, wheres(select('users'), 'id'), $user['id']);
        view('auth/form', array_merge(
            compact('email', 'user'),
            [
                'token'      => getSession('CSRF_TOKEN'),
                'requestUrl' => '/user/',
                'method'     => 'patch'
            ]
        ));
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
