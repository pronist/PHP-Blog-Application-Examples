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
 * Create a new resource
 *
 * @param resource $conn
 * @param string $table
 * @param array $args
 *
 * @return bool|array
 */
function create($conn, $table, $args)
{
    execute($conn, insert($table, array_keys($args)), ...array_values($args));
    return array_merge([ 'id' => mysqli_insert_id($conn) ], $args);
}

/**
 * Get resources
 *
 * @param resource $conn
 * @param string $table
 * @param string $mode
 * @param array $queries
 *
 * @return bool|array
 */
function get($conn, $table, $mode = 'all', $queries = [], ...$args)
{
    $mappings = [];
    foreach ($queries as $method => $value) {
        array_push($mappings, pipe($method, $value));
    }
    return call_user_func($mode, $conn, go(
        select($table),
        ...$mappings
    ), ...$args);
}

/**
 * Patch a resource
 *
 * @param resource $conn
 * @param string $table
 * @param int $id
 * @param array $args
 *
 * @return bool|array
 */
function patch($conn, $table, $id, $args)
{
    return execute($conn, go(
        update($table, array_keys($args)),
        pipe('wheres', [ 'id' ])
    ), ...array_merge(array_values($args), [ $id ]));
}

/**
 * Remove a resource
 *
 * @param resource $conn
 * @param string $table
 * @param int $id
 *
 * @return bool|array
 */
function remove($conn, $table, $id)
{
    return execute($conn, go(
        delete($table),
        pipe('wheres', [ 'id' ])
    ), $id);
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
function all($conn, $qs, ...$args)
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
            $bindMappings = [
                'string'    => 's',
                'integer'   => 'i',
                'double'    => 'd'
            ];
            $bs = array_reduce($args, function ($bs, $arg) use ($bindMappings) {
                return $bs .= $bindMappings[gettype($arg)];
            }, '');
            mysqli_stmt_bind_param($stmt, $bs, ...$args);
        }
        if (mysqli_stmt_execute($stmt)) {
            history('info', "Database::query:: Successful", [ $qs ]);
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
