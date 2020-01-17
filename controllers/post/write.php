<?php

/**
 * Write Form for a new Post (GET)
 */
function showWriteForm($user)
{
    setSession('CSRF_TOKEN', getToken());

    return view('post/form', array_merge(
        compact('user'),
        [
            'token'      => getSession('CSRF_TOKEN'),
            'requestUrl' => '/post/'
        ]
    ));
}
