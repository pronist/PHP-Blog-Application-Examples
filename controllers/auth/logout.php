<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        destroySession();
        header('Location: /');
        break;
    default:
        return http_response_code(404);
}

closeConnection($conn);
