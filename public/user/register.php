<?php

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        return store();
    case 'GET':
        return showRegisterForm();
    default:
        http_response_code(404);
}
