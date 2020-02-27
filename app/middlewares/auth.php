<?php

/**
 * Auth guard
 */

$is = guard([
    '/user/update',
    '/post/write',
    '/post/update',
    '/post/delete'
]) ?: header("Location: /auth/login");

$is = guard([ '/image/index' ]) ?: header("HTTP/1.1 400 Bad Request");

return $is;
