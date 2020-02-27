<?php

/**
 * Index
 *
 * @param int $page
 * @param int $count
 *
 * @return array
 */
function getPosts($page, $count)
{
    if ($posts = rows("SELECT * FROM posts ORDER BY id DESC LIMIT {$count} OFFSET " .  $page * $count)) {
        return transform($posts);
    }
    return [];
}
