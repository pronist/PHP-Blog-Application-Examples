<?php

/**
 * APPLICATION BOOTSTRAP
 *
 * https://github.com/pronist/phpblog/tree/basic
 *
 * Not using OOP(Object-Oriented Programming)
 * Not using PSR-4 Autoloading
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

/**
 * Start a Session
 */
ini_set('session.gc_maxlietime', 1440);
session_set_cookie_params(1440);

session_start();

/**
 * Guard
 */
guard([
    '/user/update.php',
    '/user/update_process.php',
    '/post/write.php',
    '/post/write_process.php',
    '/post/update.php',
    '/post/update_process.php',
    '/post/delete_process.php',
]) ?: header("Location: /auth/login.php");

guard([
    '/image/upload.php',
]) ?: http_response_code(400);

/**
 * Controller Mappings
 */
$controllers = [
    'index' => [
        '/index.php'
    ],
    'auth'  => [
        '/auth/login.php',
        '/auth/logout.php'
    ],
    'image' => [
        '/image/index.php'
    ],
    'post'  => [
        '/post/delete.php',
        '/post/read.php',
        '/post/update.php',
        '/post/write.php'
    ],
    'user'  => [
        '/user/register.php',
        '/user/update.php'
    ]
];

foreach ($controllers as $category => $scripts) {
    if (in_array($_SERVER['SCRIPT_NAME'], $scripts)) {
        require_once dirname(__DIR__) . '/controllers/' . $category . '.php';
    }
}