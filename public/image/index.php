<?php

require_once dirname(__DIR__, 2) . '/app.php';

/**
 * Auth
 */
$user = guard([ 'POST' ]) ?? exit;

switch (getRequestMethod()) {
    case 'GET':
        return getImage();
    case 'POST':
        return uploadImage($user);
    default:
        http_response_code(404);
}
