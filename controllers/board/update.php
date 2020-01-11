<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        setSession('CSRF_TOKEN', getToken());
        if ($user = getSession('user')) {
            list('id' => $id) = getParamsWithFilters([
                'params' => getInputParams('get'),
                'filterMappings' => [
                    'id' => [ FILTER_VALIDATE_INT ]
                ]
            ]);
            list(
                'title'     => $title,
                'content'   => $content
            ) = first($conn, wheres(select('posts'), 'id'), $id);
        } else {
            header("Location: /auth/login.php");
            break;
        }
        return view('board/update', array_merge(
            compact('id', 'title', 'content', 'user'),
            [
                'token' => getSession('CSRF_TOKEN')
            ]
        ));
    default:
        http_response_code(404);
}

closeConnection($conn);
