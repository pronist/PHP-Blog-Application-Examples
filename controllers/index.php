<?php

require_once 'includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        $userQuery = wheres(select('users'), 'id');
        $posts = array_map(function ($post) use ($conn, $userQuery) {
            list('username' => $username) = first(
                $conn,
                $userQuery,
                $post['user_id']
            );
            return getPostsWithTransform($post, $username);
        }, get($conn, select('posts')));
        return view('index', array_merge(
            compact('posts'),
            [
               'user' => getSession('user')
            ]
        ));
    default:
        http_response_code(404);
}
