<?php

/**
 * Get a Image (GET)
 */
function getImage()
{
    [ 'id' => $id ] = getParamsWithFilters([
        'params' => getInputParams('get'),
        'filterMappings' => [
            'id' => [ FILTER_SANITIZE_STRING ]
        ]
    ]);
    if (!outputFile($id)) {
        return http_response_code(404);
    }
    return http_response_code(200);
}

/**
 * Upload a Image (POST)
 */
function uploadImage($user)
{
    $file = $_FILES['upload'];
    $filename = $user['id'] . "_" . time() . "_" . hash('md5', $file['name']);
    $accepts = [
        'png',
        'jpg'
    ];
    // @codeCoverageIgnoreStart
    if ($path = upload($_FILES['upload'], $accepts, $filename)) {
        history('info', 'Post::upload:: Successful', [ $path ]);
        echo json_encode([
            'uploaded' => 1,
            'url' => '/image/?id=' . $filename
        ]);
        return;
    }
    // @codeCoverageIgnoreEnd
    history('info', 'Post::upload:: Failed', [ $file['name'] ]);
    return http_response_code(400);
}
