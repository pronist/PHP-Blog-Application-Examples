<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        view('auth/register', [
            'user'  => getSession('user'),
            'token' => getSession('CSRF_TOKEN'),
        ]);
        break;
    default:
        http_response_code(404);
}
