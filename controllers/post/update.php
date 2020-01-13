<?php

require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

/**
 * Auth
 */
$user = guard([ 'GET' ]) ?? exit;

switch (getRequestMethod()) {
    case 'GET':
        setSession('CSRF_TOKEN', getToken());
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

        view('post/form', array_merge(
            compact('id', 'title', 'content', 'user'),
            [
                'token' => getSession('CSRF_TOKEN'),
                'requestUrl' => '/post/?id=' . $id,
                'method'     => 'patch'
            ]
        ));
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
