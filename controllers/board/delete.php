<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'DELETE':
        if ($user = getSession('user')) {
            list(
                'id'    => $id,
                'token' => $token
            ) = getParamsWithFilters([
                'params' => getInputParams('delete'),
                'filterMappings' => [
                    'id' => [ FILTER_VALIDATE_INT ]
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
        }
        http_response_code(403);
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
