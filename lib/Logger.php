<?php

/**
 * Write a log message
 *
 * @param string $level
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function history($level, $message, $context = [])
{
    [ 'log' => $logs ] = include dirname(__DIR__) . "/config/storage.php";

    array_push($context, date('Y-m-d H:i:s', time()));
    array_push(
        $context,
        array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : null
    );

    $format = "[%s] %s" . str_repeat("\t%s", count($context)) . PHP_EOL;
    error_log(
        sprintf($format, strtoupper($level), $message, ...array_values($context)),
        3,
        $logs . "/" . $level . '.log'
    );
}
