<?php

/**
 * Auth
 */

return (function () {
    $is = guard([
        '/user/update.php',
        '/post/write.php',
        '/post/update.php',
        '/post/delete.php',
    ]);
    if (!$is) {
        header("Location: /auth/login.php");
        return false;
    }

    $is = guard([ '/image/index.php' ]);
    if (!$is) {
        http_response_code(400);
        return false;
    }
    return $is;
})();
