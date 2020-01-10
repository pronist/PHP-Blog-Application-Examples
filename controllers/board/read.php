<?php

require_once dirname(__DIR__) . '/includes/common.php';

switch (getRequestMethod()) {
    case 'GET':
        list('id' => $id) = getParamsWithFilters([
            'params' => getInputParams('get'),
            'filterMappings' => [
                'id' => [ FILTER_VALIDATE_INT ]
            ]
        ]);
        if ($id) {
            list(
                'user_id'       => $userId,
                'title'         => $title,
                'content'       => $content,
                'created_at'    => $createdAt
            ) = first(wheres(select('posts'), 'id'), $id);
            list(
                'username'      => $username,
                'email'         => $email,
                'description'   => $description
            ) = first(wheres(select('users'), 'id'), $userId);
            $user = getSession('user');
            $isOwner = false;
            if ($user && array_key_exists('id', $user)) {
                $isOwner = $userId == $user['id'];
            }
        } else {
            http_response_code(404);
            break;
        }
        view('board/read', array_merge(
            compact('id', 'username', 'title', 'description', 'user', 'isOwner'),
            [
                'content'   => $content,
                'picture'   => getUserProfile($email, 100),
                'createdAt' => getPostCreatedAt($createdAt),
                'update'    => "/board/update.php?id=" . $id
            ]
        ));
        break;
    default:
        http_response_code(404);
}
