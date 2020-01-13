<?php

require_once dirname(__DIR__) . '/app/bootstrap.php';

switch (getRequestMethod()) {
    case 'GET':
        $page = $_GET['page'] ?? $_GET['page'] = 0;
        $userQuery = wheres(select('users'), 'id');
        $posts = array_map(function ($post) use ($conn, $userQuery) {
            list('username' => $username) = first(
                $conn,
                $userQuery,
                $post['user_id']
            );
            $post['username'] = $username;
            $post['content'] = strip_tags(mb_substr($post['content'], 0, 200));
            $post['created_at'] = getPostCreatedAt($post['created_at']);
            $post['url'] = "/post/?id=" . $post['id'];
            return $post;
        }, get($conn, offset(limit(orderBy(select('posts'), [ 'id' => 'DESC' ]), 3), $page * 3)));

        view('index', array_merge(
            compact('posts'),
            [
               'user' => getSession('user')
            ]
        ));
        break;
    default:
        http_response_code(404);
}

closeConnection($conn);
