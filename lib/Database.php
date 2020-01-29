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
    $rows = raw($qs, $args, function ($result) {
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
 * @param string $qs
 * @param array $args
 *
 * @return bool|array
 */
function execute($qs, ...$args)
{
    return raw($qs, $args);
}

/**
 * Create a new resource
 *
 * @param string $table
 * @param array $args
 *
 * @return bool|array
 */
function create($table, $args)
{
    execute(insert($table, array_keys($args)), ...array_values($args));
    return array_merge([ 'id' => mysqli_insert_id($GLOBALS['DB_CONNECTION']) ], $args);
}

/**
 * Get resources
 *
 * @param string $table
 * @param string $mode
 * @param array $queries
 *
 * @return bool|array
 */
function get($table, $mode = 'all', $queries = [], ...$args)
{
    $mappings = [];
    foreach ($queries as $method => $value) {
        array_push($mappings, pipe($method, $value));
    }
    return call_user_func($mode, go(
        select($table),
        ...$mappings
    ), ...$args);
}

/**
 * Patch a resource
 *
 * @param string $table
 * @param int $id
 * @param array $args
 *
 * @return bool|array
 */
function patch($table, $id, $args)
{
    return execute(go(
        update($table, array_keys($args)),
        pipe('wheres', [ 'id' ])
    ), ...array_merge(array_values($args), [ $id ]));
}

/**
 * Remove a resource
 *
 * @param string $table
 * @param int $id
 *
 * @return bool|array
 */
function remove($table, $id)
{
    return execute(go(
        delete($table),
        pipe('wheres', [ 'id' ])
    ), $id);
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
function all($qs, ...$args)
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
function raw($qs, $args, $callback = null)
{
    $is = false;
    if ($GLOBALS['DB_CONNECTION']) {
        $stmt = mysqli_prepare($GLOBALS['DB_CONNECTION'], $qs);
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
