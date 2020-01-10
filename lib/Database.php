<?php

/**
 * get Rows
 *
 * @param string $qs
 * @param array $args
 *
 * @return bool|array
 */
function rows($qs, ...$args)
{
    $rows = query($qs, $args, function ($result) {
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
 * @param string $qs
 * @param array $args
 *
 * @return bool|array
 */
function execute($qs, ...$args)
{
    return query($qs, $args);
}

/**
 * get a first content
 *
 * @param string $qs
 * @param array $args
 *
 * @return array
 */
function first($qs, ...$args)
{
    return current(rows(limit($qs, 1), ...$args));
}

/**
 * get all contents
 *
 * @param string $qs
 * @param array $args
 *
 * @return array[]
 */
function get($qs, ...$args)
{
    return rows($qs, ...$args);
}

/**
 * execute a Query
 *
 * @param string $qs
 * @param array $args
 * @param callback $callback
 *
 * @return bool|array
 */
function query($qs, $args, $callback = null)
{
    $is = false;
    $connection = getConnection();
    if ($connection) {
        $result = odbc_prepare($connection, $qs);
        if (odbc_execute($result, $args)) {
            info("Database::query:: Successful", [ $qs ]);
            $rows = null;
            if (is_callable($callback)) {
                $rows = call_user_func($callback, $result);
            }
            $is = $rows ?: true;
        }
        odbc_free_result($result);
        odbc_close($connection);
    }
    return $is;
}

/**
 * get ODBC Connection
 *
 * @return resource
 */
function getConnection()
{
    list(
        'driver'    => $driver,
        'hostname'  => $hostname,
        'database'  => $database,
        'charset'   => $charset,
        'username'  => $username,
        'password'  => $password
    ) = include dirname(__DIR__) . "/config/database.php";

    $format = "Driver={%s};Server=%s;Database=%s;charset=%s";

    $connection = odbc_connect(
        sprintf($format, $driver, $hostname, $database, $charset),
        $username,
        $password
    );
    return $connection;
}
