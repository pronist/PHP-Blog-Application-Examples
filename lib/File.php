<?php

/**
 * Upload a file
 *
 * @param array $file
 * @param array $accepts
 * @param string $filename
 *
 * @return string|bool
 */
function upload($file, $accepts, $filename)
{
    [ 'upload' => $storage ] = include dirname(__DIR__) . '/config/storage.php';
    $pathParts = pathinfo($file['name']);

    // @codeCoverageIgnoreStart
    if (in_array($pathParts['extension'], $accepts) && is_uploaded_file($file['tmp_name'])) {
        $path = $storage . '/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $path)) {
            return realpath($path);
        }
    }
    // @codeCoverageIgnoreEnd

    return false;
}

/**
 * Output a file
 *
 * @param string $filename
 *
 * @return int
 */
function outputFile($filename)
{
    [ 'upload' => $storage ] = include dirname(__DIR__) . '/config/storage.php';
    $path = $storage . '/' . basename($filename);

    if (file_exists($path)) {
        header("Content-type:" . mime_content_type($path));
        return readfile($path);
    }
    return false;
}
