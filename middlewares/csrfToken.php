<?php

/**
 * CSRF Token
 */

return verify([
    [ '/auth/login', 'POST' ],
    [ '/post/write', 'POST' ],
    [ '/post/update', 'POST' ],
    [ '/post/delete', 'GET' ],
    [ '/user/register', 'POST' ],
    [ '/user/update', 'POST' ]
]) ?: header("HTTP/1.1 400 Bad Request");
