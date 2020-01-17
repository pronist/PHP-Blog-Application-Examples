<?php

require_once dirname(__DIR__) . '/app.php';

switch (getRequestMethod()) {
    case 'GET':
        return index($conn);
    default:
        http_response_code(404);
}
