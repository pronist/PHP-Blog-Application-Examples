<?php

/**
 * Action must be taken immediately.
 *
 * Example: Entire website down, database unavailable, etc. This should
 * trigger the SMS alerts and wake you up.
 *
 * @param string $message
 * @param array $context
 *
 * @codeCoverageIgnore
 *
 * @return void
 */
function alert($message, $context = [])
{
    writeLog('alert', $message, $context);
}

/**
 * Interesting events.
 *
 * Example: User logs in, SQL logs.
 *
 * @param string $message
 * @param array $context
 *
 * @codeCoverageIgnore
 *
 * @return void
 */
function info($message, $context = [])
{
    writeLog('info', $message, $context);
}

/**
 * Runtime errors that do not require immediate action but should typically
 * be logged and monitored.
 *
 * @param string $message
 * @param array $context
 *
 * @codeCoverageIgnore
 *
 * @return void
 */
function error($message, $context = [])
{
    writeLog('error', $message, $context);
}

/**
 * Write a log message
 *
 * @param string $level
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function writeLog($level, $message, $context = [])
{
    array_push($context, date('Y-m-d H:i:s', time()));
    array_push($context, array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : null);
    $format = "[%s] %s" . str_repeat("\t%s", count($context)) . PHP_EOL;
    error_log(
        sprintf($format, strtoupper($level), $message, ...array_values($context)),
        3,
        dirname(__DIR__) . "/storage/logs/" . $level . '.log'
    );
}
