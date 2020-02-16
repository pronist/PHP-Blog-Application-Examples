<?php

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        return show(filter_input(INPUT_GET, 'path', FILTER_SANITIZE_STRING));
    case 'POST':
        return store();
    default:
        http_response_code(404);
}
