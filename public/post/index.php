<?php

require_once dirname(__DIR__, 2) . "/app.php";

/**
 * Auth
 */
$user = guard([ 'POST', 'PATCH', 'DELETE' ]) ?? exit;

switch (getRequestMethod()) {
    case 'POST':
        return createNewPost($conn, $user);
    case 'GET':
        return getPost($conn);
    case 'PATCH':
        return updatePost($conn, $user);
    case 'DELETE':
        return deletePost($conn, $user);
    default:
        http_response_code(404);
}
