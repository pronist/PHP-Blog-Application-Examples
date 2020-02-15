<?php

require_once dirname(__DIR__) . '/bootstrap/app.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        return create();
    case 'GET':
        return showRegisterForm();
    default:
        http_response_code(404);
}
