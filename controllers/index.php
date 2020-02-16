<?php

/**
 * Show Posts (GET)
 *
 * @param int $page
 */
function index($page)
{
    if ($posts = rows('SELECT * FROM posts ORDER BY id DESC LIMIT 3 OFFSET ' .  $page * 3)) {
        $posts = array_map(function ($post) {
            [ 'username' => $username ] = first('SELECT * FROM users WHERE id = ? LIMIT 1', $post['user_id']);
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
    return view('index', $posts ? compact('posts') : [ 'posts' => [] ]);
}
