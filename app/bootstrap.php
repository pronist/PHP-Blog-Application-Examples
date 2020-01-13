<?php

/**
 * APPLICATION BOOTSTRAP
 */

date_default_timezone_set('Asia/Seoul');

$libraries = [
    'Logger',
    'Database',
    'QueryBuilder',
    'Session',
    'Request',
    'Response',
    'CsrfToken',
    'Auth',
    'String'
];

foreach ($libraries as $lib) {
    require_once dirname(__DIR__) . '/lib/' . $lib . '.php';
}

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    history('error', $errstr, [ $errfile, $errline ]);
    error_log(sprintf("[error] %s\t%s\t%s", $errstr, $errfile, $errline));
    return true;
});

/**
 * Database (MySQLi)
 */
$conn = getConnection(require_once dirname(__DIR__) . '/config/database.php');

/**
 * Sessions
 */
startSession();
