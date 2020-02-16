<?php

/**
 * Upload a Image (POST)
 */
function store()
{
    $file = $_FILES['upload'];
    $accepts = [
        'png',
        'jpg'
    ];
    $filename = $_SESSION['user']['id'] . "_" . time() . "_" . hash('md5', $file['name']);

    $pathParts = pathinfo($file['name']);
    if (in_array($pathParts['extension'], $accepts) && is_uploaded_file($file['tmp_name'])) {
        $path = dirname(__DIR__) . '/uploads/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $path)) {
            echo json_encode([
                'uploaded'  => 1,
                'url'       => '/image/?path=' . $filename
            ]);
        }
    }
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
