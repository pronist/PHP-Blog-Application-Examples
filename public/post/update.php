<?php

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        return update($id);
    case 'GET':
        return showUpdateForm($id);
    default:
        http_response_code(404);
}
