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
            ) = first($conn, wheres(select('users'), 'username'), $user);
            $posts = array_map(function ($post) use ($username) {
                return getPostsWithTransform($post, $username);
            }, get($conn, wheres(select('posts'), 'user_id'), $id));
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

closeConnection($conn);
