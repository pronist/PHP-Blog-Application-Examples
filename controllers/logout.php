<?php

require_once dirname(__DIR__) . '/app/bootstrap.php';

switch (getRequestMethod()) {
    case 'POST':
        destroySession();
        header('Location: /');
        break;
    default:
        return http_response_code(404);
}

closeConnection($conn);
