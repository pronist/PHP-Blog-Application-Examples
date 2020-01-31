<?php

/**
 * APPLICATION BOOTSTRAP
 *
 * https://github.com/pronist/phpblog/tree/basic
 *
 * Not using OOP(Object-Oriented Programming)
 * Not using PSR-4 Autoloading
 */

/**
 * Set Timezone to 'Asia/Seoul'
 */
date_default_timezone_set('Asia/Seoul');

/**
 * Set error handler with Logger
 */
ini_set('display_errors', 'Off');

/**
 * Get Connection for Database (MySQLi)
 */
$GLOBALS['DB_CONNECTION'] = mysqli_connect(
    'localhost',
    'root',
    'root',
    'phpblog'
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
ini_set('session.gc_maxlietime', 1440);
session_set_cookie_params(1440);

session_start();
