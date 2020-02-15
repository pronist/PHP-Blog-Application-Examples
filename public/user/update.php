<?php

require_once dirname(__DIR__) . '/bootstrap/app.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        return update($_SESSION['user']['id']);
    case 'GET':
        return showUpdateForm($_SESSION['user']['id']);
    default:
        http_response_code(404);
}
