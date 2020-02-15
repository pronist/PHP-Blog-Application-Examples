<?php

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        return show(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT));
    default:
        http_response_code(404);
}
