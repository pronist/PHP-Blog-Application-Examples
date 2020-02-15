<?php

/**
 * File uplodas
 *
 * @param array $file
 * @param array $accepts
 * @param string $filename
 *
 * @return bool
 */
function upload($file, $accepts, $filename)
{
    $pathParts = pathinfo($file['name']);
    if (in_array($pathParts['extension'], $accepts) && is_uploaded_file($file['tmp_name'])) {
        $path = dirname(__DIR__) . '/uploads/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $path)) {
            echo json_encode([
                'uploaded'  => 1,
                'url'       => '/image/?path=' . $filename
            ]);
            return true;
        }
    }
    return false;
}
