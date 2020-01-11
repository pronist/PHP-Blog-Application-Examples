<?php

$libraries = [
    'Logger',
    'Database',
    'QueryBuilder',
    'Session',
    'Request',
    'Response',
    'CsrfToken',
    'Helpers'
];

foreach ($libraries as $lib) {
    require_once dirname(__DIR__, 2) . '/lib/' . $lib . '.php';
}

date_default_timezone_set('Asia/Seoul');

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    error($errstr, [ $errfile, $errline ]);
    error_log(sprintf("[error] %s\t%s\t%s", $errstr, $errfile, $errline));
    return true;
});

$conn = getConnection(require_once dirname(__DIR__, 2) . '/config/database.php');

/**
 * Sessions
 */
startSession();

switch (getRequestMethod()) {
    case 'GET':
        setSession('CSRF_TOKEN', getToken());
        break;
}
