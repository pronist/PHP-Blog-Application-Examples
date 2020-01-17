<?php

/**
 * APPLICATION BOOTSTRAP
 *
 * https://github.com/pronist/phpblog/tree/basic
 *
 * Not using OOP(Object-Oriented Programming)
 * Not using PSR-4 Autoloading
 * Not using User components in Application Code
 */

/**
 * Set Timezone to 'Asia/Seoul'
 */
date_default_timezone_set('Asia/Seoul');

/**
 * Load libraries
 */
$libraries = scandir(dirname(__FILE__) . '/lib');
array_walk($libraries, function ($lib) {
    if (fnmatch('*.php', $lib)) {
        require_once 'lib/' . $lib;
    }
});

/**
 * Set error handler with Logger
 */
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    history('error', $errstr, [ $errfile, $errline ]);
    error_log(sprintf("[error] %s\t%s:%s", $errstr, $errfile, $errline));
    return true;
});

/**
 * Get Connection for Database (MySQLi)
 */
$conn = getConnection(require_once 'config/database.php');
register_shutdown_function(function () {
    /**
     * Close Database Connection
     */
    closeConnection($GLOBALS['conn']);
});

/**
 * Start Sessions
 */
startSession();

/**
 * Load Application Controllers
 */
require_once 'controllers' . $_SERVER['SCRIPT_NAME'];
