<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'POST':
        list(
            'email'     => $email,
            'password'  => $password,
            'token'     => $token
        ) = getParamsWithFilters([
            'params' => getInputParams('post'),
            'filterMappings' => [
                'email' => [
                    FILTER_VALIDATE_EMAIL,
                    FILTER_SANITIZE_EMAIL
                ]
            ]
        ]);
        if ($email && $password && verity($token, getSession('CSRF_TOKEN'))) {
            $user = first($conn, wheres(select('users'), 'email'), $email);
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    info('Auth::login:: Successful', [ $email ]);
                    setSession('user', $user);
                    header("Location: /");
                    break;
                }
            }
        }
        info('Auth::login:: Failed', [ $email ]);
        header("Location: /auth/login.php");
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
