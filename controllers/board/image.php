<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        list('url' => $url) = getParamsWithFilters([
            'params' => getInputParams('get'),
            'filterMappings' => [
                'url' => [ FILTER_SANITIZE_STRING ]
            ]
        ]);
        $path = dirname(__DIR__, 2) . '/storage/images/' . basename($url);
        header("Content-Type:" . mime_content_type($path));
        readfile($path);
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
