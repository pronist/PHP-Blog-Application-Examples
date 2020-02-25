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
    connect('localhost', 'root', 'root', 'phpblog') ?: exit;
    register_shutdown_function(function () {
        return close();
    });

    return routes([
        [ '/', 'get', 'index.index' ],
        [ '/auth/login', 'get', 'auth.showLoginForm' ],
        [ '/auth/login', 'post', 'auth.login' ],
        [ '/auth/logout', 'get', 'auth.logout' ],
        [ '/post/write', 'get', 'post.create' ],
        [ '/post/write', 'post', 'post.store' ],
        [ '/post/read', 'get', 'post.show' ],
        [ '/post/update', 'get', 'post.edit' ],
        [ '/post/update', 'post', 'post.update' ],
        [ '/post/delete', 'get', 'post.destory' ],
        [ '/image', 'get', 'image.show' ],
        [ '/image', 'post', 'image.store' ],
        [ '/user/register', 'get', 'user.create' ],
        [ '/user/register', 'post', 'user.store' ],
        [ '/user/update', 'get', 'user.edit' ],
        [ '/user/update', 'post', 'user.update' ]
    ]) ?: header('HTTP/1.1 404 Not Found');
})();
