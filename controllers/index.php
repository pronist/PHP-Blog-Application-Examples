<?php

/**
 * Index (GET)
 */
function index()
{
    $posts = json_encode(transform(get('posts', 'all', [
        'orderBy' => [ 'id' => 'DESC' ],
        'limit'   => 3
    ])));
    return component('app-index', compact('posts'));
}
