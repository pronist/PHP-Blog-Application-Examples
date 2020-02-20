<?php

/**
 * CSRF Token
 */

return verify([
    [ '/auth/login.php', 'POST' ],
    [ '/post/write.php', 'POST' ],
    [ '/post/update.php', 'POST' ],
    [ '/post/delete.php', 'GET' ],
    [ '/user/register.php', 'POST' ],
    [ '/user/update.php', 'POST' ]
]);
