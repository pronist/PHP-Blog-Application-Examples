<?php

/**
 * Upload a Image (POST)
 */
function store()
{
    echo __upload($_FILES['upload'], [ 'png', 'jpg' ], $_SESSION['user']['id'] . "_" . time() . "_" . hash('md5', $_FILES['upload']['name']));
}

/**
 * Get a Image (GET)
 *
 * @param string $path
 */
function show($path)
{
    echo __image(realpath(dirname(__DIR__) . '/uploads/' . basename($path)));
}
