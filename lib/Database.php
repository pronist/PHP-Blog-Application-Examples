<?php

/**
 * get Rows
 *
 * @param resource $conn
 * @param string $qs
 * @param array $args
 *
 * @return bool|array
 */
function rows($conn, $qs, ...$args)
{
    $rows = raw($conn, $qs, $args, function ($result) {
        $rows = [];
        if ((odbc_num_rows($result) > 0)) {
            while ($row = odbc_fetch_array($result)) {
                array_push($rows, $row);
            }
        }
        return $rows;
    });
    return is_array($rows) ? $rows : [];
}

/**
 * just execute a Query
 *
 * @param resource $conn
 * @param string $qs
 * @param array $args
 *
 * @return bool|array
 */
function execute($conn, $qs, ...$args)
{
    return raw($conn, $qs, $args);
}

/**
 * get a first content
 *
 * @param resource $conn
 * @param string $qs
 * @param array $args
 *
 * @return array
 */
function first($conn, $qs, ...$args)
{
    return current(rows($conn, limit($qs, 1), ...$args));
}

/**
 * get all contents
 *
 * @param resource $conn
 * @param string $qs
 * @param array $args
 *
 * @return array[]
 */
function get($conn, $qs, ...$args)
{
    return rows($conn, $qs, ...$args);
}

/**
 * execute a Query
 *
 * @param resource $conn
 * @param string $qs
 * @param array $args
 * @param callback $callback
 *
 * @return bool|array
 */
function raw($conn, $qs, $args, $callback = null)
{
    $is = false;
    if ($conn) {
        $result = odbc_prepare($conn, $qs);
        if (odbc_execute($result, $args)) {
            info("Database::query:: Successful", [ $qs ]);
            $rows = null;
            if (is_callable($callback)) {
                $rows = call_user_func($callback, $result);
            }
            $is = $rows ?: true;
        }
        odbc_free_result($result);
    }
    return $is;
}

/**
 * get ODBC Connection
 *
 * @param array $config
 *
 * @return resource
 */
function getConnection($config)
{
    $format = "Driver={%s};Server=%s;Database=%s;charset=%s";
    $connection = odbc_connect(
        sprintf($format, $config['driver'], $config['hostname'], $config['database'], $config['charset']),
        $config['username'],
        $config['password']
    );
    return $connection;
}

/**
 * @param resource $conn
 *
 * @return void
 */
function closeConnection($conn)
{
    odbc_close($conn);
}
