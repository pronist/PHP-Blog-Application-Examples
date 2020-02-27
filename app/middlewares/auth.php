<?php

/**
 * Auth guard
 */

$is = guard([
    '/user/update',
    '/post/write',
    '/post/update',
    '/post/delete'
]);

if ($is) {
    return guard([ '/image' ]) ?: header("HTTP/1.1 400 Bad Request");
}
return header("Location: /auth/login");
