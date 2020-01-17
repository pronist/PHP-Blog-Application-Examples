<?php

require_once dirname(__DIR__, 2) . '/app.php';

/**
 * Auth
 */
$user = guard([ 'PATCH' ]) ?? exit;

switch (getRequestMethod()) {
    case 'POST':
        return createNewUser($conn);
    case 'PATCH':
        return updateUser($conn, $user);
    default:
        http_response_code(404);
}
