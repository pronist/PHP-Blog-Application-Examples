<?php

/**
 * CSRF_TOKEN
 */

return (function () {
    $is = verify([
        [ '/auth/login.php', 'POST' ],
        [ '/post/write.php', 'POST' ],
        [ '/post/update.php', 'POST' ],
        [ '/post/delete.php', 'GET' ],
        [ '/user/register.php', 'POST' ],
        [ '/user/update.php', 'POST' ]
    ]);
    if (!$is) {
        http_response_code(400);
        return false;
    }
    return $is;
})();
