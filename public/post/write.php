<?php

require_once dirname(__DIR__, 2) . "/app.php";

/**
 * Auth
 */
$user = guard([ 'GET' ]) ?? exit;

switch (getRequestMethod()) {
    case 'GET':
        return showWriteForm($user);
    default:
        http_response_code(404);
}
