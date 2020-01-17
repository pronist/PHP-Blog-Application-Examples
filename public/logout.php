<?php

require_once dirname(__DIR__) . '/app.php';

switch (getRequestMethod()) {
    case 'POST':
        return logout();
    default:
        http_response_code(404);
}
