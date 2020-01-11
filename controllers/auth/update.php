<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        if ($user = getSession('user')) {
            list(
                'email'       => $email,
                'username'    => $username,
                'description' => $description
            ) = first($conn, wheres(select('users'), 'id'), $user['id']);
        } else {
            header('Location: /auth/login.php');
            break;
        }
        view('auth/update', array_merge(
            compact('email', 'username', 'description', 'user'),
            [
                'token' => getSession('CSRF_TOKEN')
            ]
        ));
        break;
    default:
        http_response_code(404);
}
