<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'POST':
        list(
            'email'         => $email,
            'password'      => $password,
            'username'      => $username,
            'description'   => $description,
            'token'         => $token
        ) = getParamsWithFilters([
            'params' => getInputParams('post'),
            'filterMappings' => [
                'email' => [
                    FILTER_VALIDATE_EMAIL,
                    FILTER_SANITIZE_EMAIL
                ],
                'description' => [
                    FILTER_SANITIZE_FULL_SPECIAL_CHARS
                ],
                'username' => [
                    FILTER_SANITIZE_FULL_SPECIAL_CHARS
                ]
            ]
        ]);
        if ($email && $username && $description && $password && verity($token, getSession('CSRF_TOKEN'))) {
            $is = execute(
                insert('users', [ 'email', 'password', 'username', 'description' ]),
                [ $email, password_hash($password, PASSWORD_DEFAULT), $username, $description ]
            );
            if ($is) {
                info('Auth::register:: Successful', [ $email ]);
                header("Location: /");
                break;
            }
            info('Auth::register:: Failed', [ $email ]);
        }
        header("Location: /auth/register.php");
        break;
    default:
        http_response_code(404);
}
