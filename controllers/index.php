<?php

/**
 * Get posts (GET)
 */
function index($conn)
{
    $page = $_GET['page'] ?? $_GET['page'] = 0;

    $posts = array_map(function ($post) use ($conn) {
        [ 'username' => $username ] = get(
            $conn,
            'users',
            'first',
            [
                'wheres' => [ 'id' ]
            ],
            $post['user_id']
        );
        $mappings = [
            'username'   => $username,
            'content'    => strip_tags(mb_substr($post['content'], 0, 200)),
            'created_at' => getPostCreatedAt($post['created_at']),
            'url'        => "/post/?id=" . $post['id']
        ];
        return array_merge($post, $mappings);
    }, get($conn, 'posts', 'all', [
        'orderBy' => [ 'id' => 'DESC' ],
        'limit'   => 3,
        'offset'  => $page * 3
    ]));
    return view('index', array_merge(
        compact('posts'),
        [
           'user' => getSession('user')
        ]
    ));
}
