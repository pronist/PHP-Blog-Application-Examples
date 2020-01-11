<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        if ($user = getSession('user')) {
            view('board/write', array_merge(
                compact('user'),
                [
                    'token' => getSession('CSRF_TOKEN')
                ]
            ));
            break;
        } else {
            header("Location: /auth/login.php");
            break;
        }
    default:
        http_response_code(404);
}

closeConnection($conn);
