<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'POST':
        if ($user = getSession('user')) {
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
                        'url' => '/board/image.php?url=' . $filename
                    ]);
                    break;
                }
            } else {
                history('info', 'Post::upload:: Failed', [ $file['name'] ]);
                http_response_code(400);
                break;
            }
        } else {
            http_response_code(403);
            break;
        }
    default:
        http_response_code(404);
}

closeConnection($conn);
