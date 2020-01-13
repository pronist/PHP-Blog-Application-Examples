<?php

require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

/**
 * Auth
 */
$user = guard([ 'POST', 'PATCH', 'DELETE' ]) ?? exit;

switch (getRequestMethod()) {
    case 'POST':
        list(
            'title'     => $title,
            'content'   => $content,
            'token'     => $token
        ) = getParamsWithFilters([
            'params' => getInputParams('post'),
            'filterMappings' => [
                'title'     => [ FILTER_SANITIZE_FULL_SPECIAL_CHARS ]
            ]
        ]);
        if ($title && $content && verity($token, getSession('CSRF_TOKEN'))) {
            $is = execute(
                $conn,
                insert('posts', [ 'user_id ', 'created_at', 'title', 'content' ]),
                $user['id'],
                date('Y-m-d H:i:s', time()),
                $title,
                removeTags($content, 'script')
            );
            if ($is) {
                history('info', 'Post::write:: Successful', [ $user['id'] ]);
                header('Location: /');
                break;
            }
        }
        history('info', 'Post::write:: Failed', [ $user['id'] ]);
        header("Location: /post/write.php");
        break;
    case 'GET':
        setSession('CSRF_TOKEN', getToken());
        if (isset($_GET['id'])) {
            list('id' => $id) = getParamsWithFilters([
                'params' => getInputParams('get'),
                'filterMappings' => [
                    'id' => [ FILTER_VALIDATE_INT ]
                ]
            ]);
            list(
                'user_id'       => $userId,
                'title'         => $title,
                'content'       => $content,
                'created_at'    => $createdAt
            ) = first($conn, wheres(select('posts'), 'id'), $id);

            list(
                'username'      => $username,
                'email'         => $email
            ) = first($conn, wheres(select('users'), 'id'), $userId);

            $isOwner = false;
            $user = getSession('user');

            if ($user && array_key_exists('id', $user)) {
                $isOwner = $userId == $user['id'];
            }
            view('post/read', array_merge(
                compact('username', 'title', 'isOwner', 'user'),
                [
                    'content'   => $content,
                    'createdAt' => getPostCreatedAt($createdAt),
                    'update'    => "/post/update.php?id=" . $id
                ]
            ));
            echo jsVar(array_merge(
                compact('id'),
                [
                    'token' => getSession('CSRF_TOKEN')
                ]
            ));
        } else {
            http_response_code(404);
        }
        break;
    case 'PATCH':
        list(
            'title'     => $title,
            'content'   => $content,
            'token'     => $token
        ) = getParamsWithFilters([
            'params' => getInputParams('patch'),
            'filterMappings' => [
                'title' => [ FILTER_SANITIZE_FULL_SPECIAL_CHARS ]
            ]
        ]);

        list('id' => $id) = getParamsWithFilters([
            'params' => getInputParams('get'),
            'filterMappings' => [
                'id'    => [ FILTER_VALIDATE_INT ]
            ]
        ]);

        if ($id && $title && $content && verity($token, getSession('CSRF_TOKEN'))) {
            list('user_id' => $userId) = first($conn, wheres(select('posts'), 'id'), $id);
            if ($user['id'] == $userId) {
                $is = execute(
                    $conn,
                    wheres(update('posts', [ 'title', 'content' ]), 'id'),
                    $title,
                    removeTags($content, 'script'),
                    $id
                );
                if ($is) {
                    history('info', 'Post::update:: Successful', [ $id ]);
                    header("Location: /post/?id=" . $id);
                    break;
                }
            }
        }
        history('info', 'Post::update:: Failed', [ $id ]);
        header("Location: /post/update.php?id=" . $id);
        break;
    case 'DELETE':
        list('token' => $token) = getParamsWithFilters([
            'params' => getInputParams('delete'),
            'filterMappings' => [
                'token' => [ FILTER_SANITIZE_STRING ]
            ]
        ]);

        list('id' => $id) = getParamsWithFilters([
            'params' => getInputParams('get'),
            'filterMappings' => [
                'id'    => [ FILTER_VALIDATE_INT ]
            ]
        ]);

        if ($id && verity($token, getSession('CSRF_TOKEN'))) {
            list('user_id' => $userId) = first($conn, wheres(select('posts'), 'id'), $id);
            if ($user['id'] == $userId) {
                if (execute($conn, wheres(delete('posts'), 'id'), $id)) {
                    history('info', 'Post::delete:: Successful', [ $id ]);
                    http_response_code(204);
                    break;
                }
            }
        }
        history('info', 'Post::delete:: Failed', [ $id ]);
        http_response_code(400);
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
