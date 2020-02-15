<?php

/**
 * Upload a Image (POST)
 */
function create()
{
    $file = $_FILES['upload'];
    return upload(
        $file,
        [
            'png',
            'jpg'
        ],
        $_SESSION['user']['id'] . "_" . time() . "_" . hash('md5', $file['name'])
    );
}

/**
 * Get a Image (GET)
 *
 * @param string $path
 */
function show($path)
{
    $filepath = realpath(dirname(__DIR__) . '/uploads/' . basename($path));
    if (file_exists($filepath)) {
        header("Content-type:" . mime_content_type($path));
        return readfile($filepath);
    }
}
