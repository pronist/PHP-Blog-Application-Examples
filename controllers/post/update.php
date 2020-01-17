<?php

/**
 * Update Form for Post informations (GET)
 */
function showPostUpdateForm($conn, $user)
{
    setSession('CSRF_TOKEN', getToken());

    [ 'id' => $id ] = getParamsWithFilters([
        'params' => getInputParams('get'),
        'filterMappings' => [
            'id' => [ FILTER_VALIDATE_INT ]
        ]
    ]);
    [
        'title'     => $title,
        'content'   => $content
    ] = get($conn, 'posts', 'first', [ 'wheres' => [ 'id' ] ], $id);

    return view('post/form', array_merge(
        compact('id', 'title', 'content', 'user'),
        [
            'token' => getSession('CSRF_TOKEN'),
            'requestUrl' => '/post/?id=' . $id,
            'method'     => 'patch'
        ]
    ));
}
