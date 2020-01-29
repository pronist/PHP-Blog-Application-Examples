<?php

/**
 * transform Post
 *
 * @param array $posts
 *
 * @return array
 */
function transform($posts)
{
    return array_map(function ($post) {
        [ 'username' => $username ] = get('users', 'first', [ 'wheres' => [ 'id' ] ], $post['user_id']);

        $content = param(mb_substr(strip_tags($post['content']), 0, 200), [ FILTER_SANITIZE_FULL_SPECIAL_CHARS ]);
        $mappings = array_merge(
            compact('username', 'content'),
            [
                'created_at' => getPostCreatedAt($post['created_at']),
                'url'        => "/post/" . $post['id']
            ]
        );
        return array_merge($post, $mappings);
    }, $posts);
}
