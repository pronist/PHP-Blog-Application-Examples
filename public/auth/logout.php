<?php

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        return logout();
    default:
        http_response_code(404);
}
