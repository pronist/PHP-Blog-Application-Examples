<?php

/**
 * Upload a Image (POST)
 */
function store()
{
    $file = $_FILES['upload'];
    echo uploadImage($file, config('image.accepts'), hash('md5', time() . $file['name']));
}

/**
 * Get a Image (GET)
 *
 * @param string $path
 */
function show($path)
{
    echo getImage(realpath(config('image.path') . basename($path)));
}
