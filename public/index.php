<?php

/**
 * APPLICATION BOOTSTRAP
 *
 * https://github.com/pronist/phpblog/tree/basic
 *
 * Not using OOP(Object-Oriented Programming)
 * Not using PSR-4 Autoloading
 */

(function () {
    /**
     * Set Timezone to 'Asia/Seoul'
     */
    date_default_timezone_set('Asia/Seoul');

    /**
     * Load libraries
     */
    foreach (scandir(dirname(__DIR__) . '/lib') as $lib) {
        if (fnmatch('*.php', $lib)) {
            require_once dirname(__DIR__) . '/lib/' . $lib;
        }
    }

    /**
     * Set error handler with Logger
     */
    ini_set('display_errors', 'Off');

    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        history('error', $errstr, [ $errfile, $errline ]);
        error_log(sprintf("[error] %s\t%s:%s", $errstr, $errfile, $errline));
        return true;
    });

    /**
     * Loads Environment Variables
     */
    $fh = fopen(dirname(__DIR__) . '/.env', 'r');

    while ($env = fgets($fh)) {
        if (preg_match('/^(.*)\=(.*)$/', $env, $matches)) {
            [, $key, $value] = $matches;
            setEnv($key, trim($value));
        }
    }

    /**
     * Get Connection for Database (MySQLi)
     */
    $GLOBALS['DB_CONNECTION'] = mysqli_connect(
        env('DB_HOSTNAME'),
        env('DB_USERNAME'),
        env('DB_PASSWORD'),
        env('DB_DATABASE')
    );
    register_shutdown_function(function () {
        /**
         * Close Database Connection
         */
        if (array_key_exists('DB_CONNECTION', $GLOBALS)) {
            mysqli_close($GLOBALS['DB_CONNECTION']);
        }
    });

    /**
     * Start a Session
     */
    [
        'lifetime'          => $lifetime,
        'cookie_lifetime'   => $cookieLifeTime
    ] = include dirname(__DIR__) . "/config/session.php";

    ini_set('session.gc_maxlietime', $lifetime);
    session_set_cookie_params($cookieLifeTime);

    [ 'session' => $session ] = include dirname(__DIR__) . "/config/storage.php";
    session_save_path($session);
    session_start() ?: history('alert', "Session:: Cannot start");

    /**
     * Routes
     */
    setRoutes([
        '/'         => [
            [ '/',              'get',      'index',                [] ]
        ],
        '/auth'     => [
            [ '/login',         'get',      'showLoginForm',        [] ],
            [ '/login',         'post',     'login',                [] ],
            [ '/logout',        'post',     'logout',               [ 'guard' ] ]
        ],
        '/user'     => [
            [ '/register',      'get',      'showRegisterForm',     [] ],
            [ '/',              'post',     'createNewUser',        [] ],
            [ '/update',        'get',      'showUserUpdateForm',   [ 'guard' ] ],
            [ '/',              'patch',    'updateUser',           [ 'guard' ] ]
        ],
        '/post'     => [
            [ '/write',         'get',      'showWriteForm',        [ 'guard' ] ],
            [ '/update/{id}',   'get',      'showPostUpdateForm',   [ 'guard' ] ],
            [ '/',              'get',      'getPosts',             [] ],
            [ '/',              'post',     'createNewPost',        [] ],
            [ '/{id}',          'get',      'showPost',             [] ],
            [ '/{id}',          'patch',    'updatePost',           [ 'guard' ] ],
            [ '/{id}',          'delete',   'deletePost',           [ 'guard' ] ]
        ],
        '/image'    => [
            [ '/{id}',          'get',      'getImage',             [] ],
            [ '/',              'post',     'updateImage',          [ 'guard' ] ]
        ]
    ]);
})();
