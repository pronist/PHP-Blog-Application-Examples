<?php

/**
 * Upload a Image (POST)
 */
function store()
{
    echo uploadImage($_FILES['upload'], conf('image.accepts'), $_SESSION['user']['id'] . "_" . time() . "_" . hash('md5', $_FILES['upload']['name']));
}

/**
 * Get a Image (GET)
 *
 * @param string $path
 */
function show($path)
{
    echo getImage(realpath(conf('image.path') . basename($path)));
}
