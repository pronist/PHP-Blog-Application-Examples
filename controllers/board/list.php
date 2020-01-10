<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        list('user' => $user) = getParamsWithFilters([
            'params' => getInputParams('get'),
            'filterMappings' => [
                'user' => [ FILTER_SANITIZE_STRING ]
            ]
        ]);
        if ($user) {
            list(
                'email'         => $email,
                'id'            => $id,
                'username'      => $username,
                'description'   => $description
            ) = first(wheres(select('users'), 'username'), $user);
            $posts = array_map(function ($post) {
                $post['content'] = getSubContentWithoutHTMLTags($post['content'], 200);
                $post['created_at'] = getPostCreatedAt($post['created_at']);
                $post['url'] = "/board/read.php?id=" . $post['id'];
                return $post;
            }, get(wheres(select('posts'), 'user_id'), $id));
        } else {
            http_response_code(404);
            break;
        }
        view('board/list', array_merge(
            compact('email', 'username', 'description', 'posts'),
            [
                'user'    => getSession('user'),
                'picture' => getUserProfile($email, 80)
            ]
        ));
        break;
    default:
        http_response_code(404);
}
