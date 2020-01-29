<?php

/**
 * Return parameter
 *
 * @param mixed
 *
 * @return mixed
 */
function identity($arg)
{
    return $arg;
}

/**
 * Function execution on pipeline
 *
 * @param mixed $r
 * @param array $pipes
 *
 * @return mixed
 */
function go($r, ...$pipes)
{
    return array_reduce($pipes, function ($r, $pipeArgs) {
        [ $fn, $args ] = $pipeArgs;
        return call_user_func($fn, $r, ...$args);
    }, $r);
}

/**
 * Create a pipe for 'go'
 *
 * @param string $fn
 * @param array $args
 */
function pipe($fn, ...$args)
{
    $pipe = [ $fn ];
    array_push($pipe, array_map('identity', $args));

    return $pipe;
}
