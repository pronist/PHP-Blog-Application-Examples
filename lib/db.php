<?php

/**
 * Exists
 *
 * @param string $query
 * @param array $params
 *
 * @return mixed
 */
function first($query, ...$params)
{
    return __raw($query, $params, function ($result) {
        if ($item = mysqli_fetch_assoc($result)) {
            if (is_array($item) && count($item) > 0) {
                return $item;
            }
        }
        return [];
    });
}

/**
 * get Rows
 *
 * @param string $query
 * @param array $params
 *
 * @return array
 */
function rows($query, ...$params)
{
    return __raw($query, $params, function ($result) {
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($rows, $row);
        }
        return $rows;
    });
}

/**
 * Execute a query
 *
 * @param string $query
 * @param array $params
 *
 * @return bool
 */
function execute($query, ...$params)
{
    return __raw($query, $params);
}

/**
 * Execute query raw
 *
 * @param string $query
 * @param string array
 * @param callback $callback
 *
 * @return bool|array
 */
function __raw($query, $params = [], $callback = null)
{
    $is = false;
    if (count($params) == count(array_filter($params)) && array_key_exists('DB_CONNECTION', $GLOBALS) && $GLOBALS['DB_CONNECTION']) {
        $stmt = mysqli_prepare($GLOBALS['DB_CONNECTION'], $query);
        if (count($params) > 0) {
            $mappings = [
                'integer'   => 'i',
                'string'    => 's',
                'double'    => 'd'
            ];
            $bs = array_reduce($params, function ($bs, $arg) use ($mappings) {
                return $bs .= $mappings[gettype($arg)];
            }, '');
            mysqli_stmt_bind_param($stmt, $bs, ...array_values($params));
        }
        if (mysqli_stmt_execute($stmt)) {
            if (is_callable($callback)) {
                $res = call_user_func($callback, mysqli_stmt_get_result($stmt));
            }
            $is = $res ?? true;
        }
        mysqli_stmt_close($stmt);
    }
    return $is;
}
