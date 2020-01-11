<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'PATCH':
        if ($user = getSession('user')) {
            list(
                'id'        => $id,
                'title'     => $title,
                'content'   => $content,
                'token'     => $token
            ) = getParamsWithFilters([
                'params' => getInputParams('patch'),
                'filterMappings' => [
                    'id'    => [ FILTER_VALIDATE_INT ],
                    'title' => [ FILTER_SANITIZE_FULL_SPECIAL_CHARS ]
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
                        info('Post::update:: Successful', [ $id ]);
                        header("Location: /board/read.php?id=" . $id);
                        break;
                    }
                }
            }
            info('Post::update:: Failed', [ $id ]);
            header("Location: /board/update.php?id=" . $id);
            break;
        } else {
            header("Location: /auth/login.php");
            break;
        }
    default:
        http_response_code(404);
}

closeConnection($conn);
