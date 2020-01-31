<?php

require_once dirname(__DIR__) . '/bootstrap/app.php';

$id = filter_input(INPUT_GET, 'id');

$path = dirname(__DIR__) . '/uploads/' . basename($id);

if (file_exists($path)) {
    header("Content-type:" . mime_content_type($path));
    return readfile($path);
}

return http_response_code(404);
