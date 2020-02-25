<?php

/**
 * Show Posts (GET)
 *
 * @param int $page
 */
function index($page = 0)
{
    return view('index', [ 'posts' => __index(filter_var($page, FILTER_VALIDATE_INT), 3) ]);
}
