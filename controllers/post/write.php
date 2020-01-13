<?php

require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

/**
 * Auth
 */
$user = guard([ 'GET' ]) ?? exit;

switch (getRequestMethod()) {
    case 'GET':
        setSession('CSRF_TOKEN', getToken());
        view('post/form', array_merge(
            compact('user'),
            [
                'token'      => getSession('CSRF_TOKEN'),
                'requestUrl' => '/post/'
            ]
        ));
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
