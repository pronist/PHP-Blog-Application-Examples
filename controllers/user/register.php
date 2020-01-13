<?php

require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

switch (getRequestMethod()) {
    case 'GET':
        setSession('CSRF_TOKEN', getToken());
        view('auth/form', [
            'user'       => getSession('user'),
            'token'      => getSession('CSRF_TOKEN'),
            'requestUrl' => '/user/'
        ]);
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
