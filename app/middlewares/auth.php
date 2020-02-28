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
    return guard([ '/image' ]) ?: reject(400);
}
return redirect("/auth/login");
