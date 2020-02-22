<?php

/**
 * APPLICATION BOOTSTRAP
 *
 * https://github.com/pronist/phpblog/tree/basic
 *
 * Not using OOP(Object-Oriented Programming)
 * Not using PSR-4 Autoloading
 */

return (function () {
    /**
     * Libraries
     */
    foreach (scandir(dirname(__DIR__) . '/lib') as $file) {
        if (fnmatch('*.php', $file)) {
            require_once dirname(__DIR__) . '/lib/' . $file;
        }
    }

    /**
     * Set Timezone to 'Asia/Seoul'
     */
    date_default_timezone_set('Asia/Seoul');

    /**
     * Disable display errors
     */
    ini_set('display_errors', 'Off');

    /**
     * Start a Session
     */
    ini_set('session.gc_maxlietime', 1440);
    session_set_cookie_params(1440);

    session_start();

    /**
     * Middlewares
     */
    $middlewares = [
        'auth.php',
        'csrfToken.php',
        'require.php'
    ];
    foreach ($middlewares as $file) {
        (require_once dirname(__DIR__) . '/middlewares/' . $file) ?: exit;
    }

    /**
     * Get Connection for Database (MySQLi)
     */
    $GLOBALS['DB_CONNECTION'] = mysqli_connect(
        'localhost',
        'root',
        'root',
        'phpblog'
    );
    if (!$GLOBALS['DB_CONNECTION']) {
        exit;
    }
    register_shutdown_function(function () {
        /**
         * Close Database Connection
         */
        if (array_key_exists('DB_CONNECTION', $GLOBALS) && $GLOBALS['DB_CONNECTION']) {
            mysqli_close($GLOBALS['DB_CONNECTION']);
        }
    });

    return routes([
        [ '/', 'get', 'index.index' ],
        [ '/auth/login', 'get', 'auth.showLoginForm' ],
        [ '/auth/login', 'post', 'auth.login' ],
        [ '/auth/logout', 'get', 'auth.logout' ],
        [ '/post/write', 'get', 'post.showStoreForm' ],
        [ '/post/write', 'post', 'post.store' ],
        [ '/post/read', 'get', 'post.show' ],
        [ '/post/update', 'get', 'post.showUpdateForm' ],
        [ '/post/update', 'post', 'post.update' ],
        [ '/post/delete', 'post', 'post.destroy' ],
        [ '/image', 'get', 'image.show' ],
        [ '/image', 'post', 'image.store' ],
        [ '/user/register', 'get', 'user.showRegisterForm' ],
        [ '/user/register', 'post', 'user.store' ],
        [ '/user/update', 'get', 'user.showUpdateForm' ],
        [ '/user/update', 'post', 'user.update' ]
    ]);
})();
