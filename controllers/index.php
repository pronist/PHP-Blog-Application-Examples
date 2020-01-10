<?php

require_once 'includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        $userQuery = wheres(select('users'), 'id');
        $posts = array_map(function ($post) use ($userQuery) {
            list('username' => $username) = first(
                $userQuery,
                $post['user_id']
            );
            $post['username'] = $username;
            $post['author'] = "/board/list.php?user=" . urlencode($post['username']);
            $post['content'] = getSubContentWithoutHTMLTags($post['content'], 200);
            $post['created_at'] = getPostCreatedAt($post['created_at']);
            $post['url'] = "/board/read.php?id=" . $post['id'];
            return $post;
        }, get(select('posts')));
        return view('index', array_merge(
            compact('posts'),
            [
               'user' => getSession('user')
            ]
        ));
    default:
        http_response_code(404);
}
