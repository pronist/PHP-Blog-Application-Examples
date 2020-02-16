<?php

require_once dirname(__DIR__) . '/bootstrap/app.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        return index(filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 0);
    default:
        http_response_code(404);
}
