<?php

/**
 * is Owner
 *
 * @param int $id
 *
 * @return bool
 */
function owner($id)
{
    [ 'user_id' => $userId ] = current(rows('SELECT * FROM posts WHERE id = ? LIMIT 1', $id));
    if (array_key_exists('user', $_SESSION)) {
        return $userId == $_SESSION['user']['id'];
    }
    return false;
}

/**
 * post
 *
 * @param string $query
 * @param string $redirectOnSuccess
 * @param string $redirectOnFailure
 * @param string $token
 * @param array $params
 *
 * @return void
 */
function post($query, $redirectOnSuccess, $redirectOnFailure, $token, ...$params)
{
    if (hash_equals($token, $_SESSION['CSRF_TOKEN'])) {
        if (check($params) && execute($query, ...array_values($params))) {
            return header("Location: " . $redirectOnSuccess);
        }
    }
    return header("Location: " . $redirectOnFailure);
}

/**
 * Transform posts
 *
 * @param array $posts
 *
 * @return array
 */
function transform($posts)
{
    return array_map(function ($post) {
        [ 'username' => $username ] = current(rows('SELECT * FROM users WHERE id = ? LIMIT 1', $post['user_id']));
        $content = filter_var(mb_substr(strip_tags($post['content']), 0, 200), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mappings = array_merge(
            compact('username', 'content'),
            [
                'created_at' => date('h:i A, M j', strtotime($post['created_at'])),
                'url'        => "/post/read.php?id=" . $post['id']
            ]
        );
        return array_merge($post, $mappings);
    }, $posts);
}
