<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'POST':
        if ($user = getSession('user')) {
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
                    insert('posts', [ 'user_id ', 'created_at', 'title', 'content' ]),
                    $user['id'],
                    date('Y-m-d H:i:s', time()),
                    $title,
                    removeTags($content, 'script')
                );
                if ($is) {
                    info('Post::write:: Successful', [ $user['id'] ]);
                    header("Location: /board/list.php?user=" . $user['username']);
                    break;
                }
                info('Post::write:: Failed', [ $user['id'] ]);
            }
            header("Location: /board/write.php");
            break;
        } else {
            header("Location: /auth/login.php");
            break;
        }
    default:
        http_response_code(404);
}
