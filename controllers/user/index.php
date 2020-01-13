<?php

require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

/**
 * Auth
 */
$user = guard([ 'PATCH' ]) ?? exit;

switch (getRequestMethod()) {
    case 'POST':
        list(
            'email'         => $email,
            'password'      => $password,
            'token'         => $token
        ) = getParamsWithFilters([
            'params' => getInputParams('post'),
            'filterMappings' => [
                'email' => [
                    FILTER_VALIDATE_EMAIL,
                    FILTER_SANITIZE_EMAIL
                ]
            ]
        ]);
        if ($email & $password && verity($token, getSession('CSRF_TOKEN'))) {
            $username = current(explode('@', $email));
            $is = execute(
                $conn,
                insert('users', [ 'email', 'password', 'username' ]),
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $username
            );
            if ($is) {
                history('info', 'Auth::register:: Successful', [ $email ]);
                header("Location: /login.php");
                break;
            }
        }
        history('info', 'Auth::register:: Failed', [ $email ]);
        header("Location: /user/register.php");
        break;
    case 'PATCH':
        list(
            'email'         => $email,
            'password'      => $password,
            'token'         => $token
        ) = getParamsWithFilters([
            'params' => getInputParams('patch'),
            'filterMappings' => [
                'email' => [
                    FILTER_VALIDATE_EMAIL,
                    FILTER_SANITIZE_EMAIL
                ]
            ]
        ]);

        if ($email && $password && verity($token, getSession('CSRF_TOKEN'))) {
            $username = current(explode('@', $email));
            $is = execute(
                $conn,
                wheres(update('users', [ 'email', 'password', 'username' ]), 'id'),
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $username,
                $user['id']
            );
            if ($is) {
                history('info', "Auth::update:: Successful", [ $email ]);
                destroySession();
                header('Location: /auth/login.php');
                break;
            }
        }
        history('info', "Auth::update:: Failed", [ $email ]);
        header("Location: /user/update.php");
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
