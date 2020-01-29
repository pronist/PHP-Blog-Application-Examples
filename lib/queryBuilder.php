<?php

/**
 * Insert
 *
 * @param string $table
 * @param array $fields
 *
 * @return string
 */
function insert($table, $fields)
{
    return queryString("INSERT INTO {$table}(%s) VALUES(%s)", [
        [ $fields, '%s', ',' ],
        [ range(0, count($fields) - 1), '?', ',' ]
    ]);
}

/**
 * Select
 *
 * @param string $table
 * @param array $fields
 * @param array $wheres
 *
 * @return string
 */
function select($table, $fields = ['*'])
{
    return queryString("SELECT %s FROM {$table}", [
        [ $fields, "%s", ', ' ],
    ]);
}

/**
 * Update
 *
 * @param string $table
 * @param array $args
 *
 * @return string
 */
function update($table, $fields)
{
    return queryString("UPDATE {$table} SET %s", [
       [ $fields, '%s = ?', ', ' ]
    ]);
}

/**
 * Delete
 *
 * @param string $table
 *
 * @return string
 */
function delete($table)
{
    return queryString("DELETE FROM {$table}");
}

/**
 * Wheres
 *
 * @param string $qs
 * @param array $wheres
 *
 * @return string
 */
function wheres($qs, $wheres)
{
    return $qs .= queryString(' WHERE %s', [
        [ $wheres, '%s = ?', ' AND' ]
    ]);
}

/**
 * limit
 *
 * @param string $qs
 * @param int $count
 *
 * @return string
 */
function limit($qs, $count)
{
    return $qs .= " LIMIT " . $count;
}

/**
 * limit
 *
 * @param string $qs
 * @param int $start
 *
 * @return string
 */
function offset($qs, $start)
{
    return $qs .= " OFFSET " . $start;
}


/**
 * order by
 *
 * @param string $qs
 * @param array $fields
 */
function orderBy($qs, $fields)
{
    foreach ($fields as $key => $value) {
        $fields[$key] = $key . ' ' . $value;
    }
    return $qs .= queryString(' ORDER BY %s', [
        [ $fields, '%s', ', ' ]
    ]);
}

/**
 * get Query string
 *
 * @param string $format
 * @param array $args
 *
 * @return string
 */
function queryString($format, $args = [])
{
    $queryStrings = [];
    foreach ($args as [ $a, $f, $t ]) {
        $qs = null;
        if (count($a) > 0) {
            foreach ($a as $k => $v) {
                $qs .= sprintf($f, $v) . $t;
            }
            $qs = substr($qs, 0, strlen($qs) - strlen($t));
        }
        array_push($queryStrings, $qs ?? '');
    }
    return sprintf($format, ...$queryStrings);
}
