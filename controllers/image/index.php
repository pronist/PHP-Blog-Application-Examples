<?php

require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

/**
 * Auth
 */
$user = guard([ 'POST' ]) ?? exit;

switch (getRequestMethod()) {
    case 'GET':
        list('id' => $id) = getParamsWithFilters([
            'params' => getInputParams('get'),
            'filterMappings' => [
                'id' => [ FILTER_SANITIZE_STRING ]
            ]
        ]);
        $path = dirname(__DIR__, 2) . '/storage/images/' . basename($id);
        header("Content-Type:" . mime_content_type($path));
        readfile($path);
        break;
    case 'POST':
        $file = $_FILES['upload'];
        $filename = $user['id'] . "_" . time() . "_" . hash('md5', $file['name']);
        $path = dirname(__DIR__, 2) . "\/storage\/images\/" . $filename;
        $accepts = [
            'png',
            'jpg'
        ];
        $pathParts = pathinfo($file['name']);
        if (in_array($pathParts['extension'], $accepts) && is_uploaded_file($file['tmp_name'])) {
            if (move_uploaded_file($file['tmp_name'], $path)) {
                history('info', 'Post::upload:: Successful', [ $path ]);
                echo json_encode([
                    'uploaded' => 1,
                    'url' => '/image/?id=' . $filename
                ]);
                break;
            }
        } else {
            history('info', 'Post::upload:: Failed', [ $file['name'] ]);
            http_response_code(400);
            break;
        }
    default:
        http_response_code(404);
}

closeConnection($conn);
