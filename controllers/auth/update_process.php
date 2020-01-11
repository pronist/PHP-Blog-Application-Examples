<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'PATCH':
        if ($user = getSession('user')) {
            list(
                'email'         => $email,
                'password'      => $password,
                'username'      => $username,
                'description'   => $description,
                'token'         => $token
            ) = getParamsWithFilters([
                'params' => getInputParams('patch'),
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
                    $conn,
                    wheres(update('users', [ 'email', 'password', 'username', 'description' ]), 'id'),
                    $email,
                    password_hash($password, PASSWORD_DEFAULT),
                    $username,
                    $description,
                    $user['id']
                );
                if ($is) {
                    info("Auth::update:: Successful", [ $email ]);
                    destroySession();
                    header('Location: /');
                    break;
                }
                info("Auth::update:: Failed", [ $email ]);
            }
            header("Location: /auth/update.php");
            break;
        }
        header('Location: /auth/login.php');
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
