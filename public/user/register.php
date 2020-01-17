<?php

require_once dirname(__DIR__, 2) . '/app.php';

switch (getRequestMethod()) {
    case 'GET':
        return showRegisterForm();
    default:
        http_response_code(404);
}
