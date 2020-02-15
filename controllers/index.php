<?php

/**
 * Show Posts (GET)
 */
function index()
{
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 0;

    return view('index', [
        'posts' => transform(rows('SELECT * FROM posts ORDER BY id DESC LIMIT 3 OFFSET ?', $page * 3))
    ]);
}
