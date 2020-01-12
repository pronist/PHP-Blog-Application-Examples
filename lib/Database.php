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
        if ((mysqli_num_rows($result) > 0)) {
            while ($row = mysqli_fetch_assoc($result)) {
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
        $stmt = mysqli_prepare($conn, $qs);
        if (count($args) > 0) {
            $bs = '';
            $bindMappings = [
                'string'    => 's',
                'integer'   => 'i',
                'double'    => 'd'
            ];
            foreach ($args as $arg) {
                if (array_key_exists(gettype($arg), $bindMappings)) {
                    $bs .= $bindMappings[gettype($arg)];
                }
            }
            mysqli_stmt_bind_param($stmt, $bs, ...$args);
        }
        if (mysqli_stmt_execute($stmt)) {
            info("Database::query:: Successful", [ $qs ]);
            $rows = null;
            if (is_callable($callback)) {
                $rows = call_user_func($callback, mysqli_stmt_get_result($stmt));
            }
            $is = $rows ?: true;
        }
        mysqli_stmt_close($stmt);
    }
    return $is;
}

/**
 * get mysqli Connection
 *
 * @param array $config
 *
 * @return object
 */
function getConnection($config)
{
    return mysqli_connect(
        $config['hostname'],
        $config['username'],
        $config['password'],
        $config['database']
    );
}

/**
 * @param resource $conn
 *
 * @return bool
 */
function closeConnection($conn)
{
    return mysqli_close($conn);
}
