<?php

/**
 * Write a new Post (POST)
 */
function createNewPost($conn, $user)
{
    [
        'title'     => $title,
        'content'   => $content,
        'token'     => $token
    ] = getParamsWithFilters([
        'params' => getInputParams('post'),
        'filterMappings' => [
            'title'     => [ FILTER_SANITIZE_FULL_SPECIAL_CHARS ]
        ]
    ]);
    if ($title && $content && verity($token, getSession('CSRF_TOKEN'))) {
        $is = create($conn, 'posts', [
            'user_id'       => $user['id'],
            'created_at'    => date('Y-m-d H:i:s', time()),
            'title'         => $title,
            'content'       => removeTags($content, 'script')
        ]);
        if ($is) {
            history('info', 'Post::write:: Successful', [ $user['id'] ]);
            return header('Location: /');
        }
    }
    history('info', 'Post::write:: Failed', [ $user['id'] ]);
    return header("Location: /post/write.php");
}


/**
 * Get posts (GET)
 */
function getPost($conn)
{
    setSession('CSRF_TOKEN', getToken());

    if (isset($_GET['id'])) {
        [ 'id' => $id ] = getParamsWithFilters([
            'params' => getInputParams('get'),
            'filterMappings' => [
                'id' => [ FILTER_VALIDATE_INT ]
            ]
        ]);
        [
            'user_id'       => $userId,
            'title'         => $title,
            'content'       => $content,
            'created_at'    => $createdAt
        ] = get($conn, 'posts', 'first', [ 'wheres' => [ 'id' ] ], $id);
        [
            'username'      => $username,
            'email'         => $email
        ] = get($conn, 'users', 'first', [ 'wheres' => [ 'id' ] ], $userId);

        $isOwner = false;
        $user = getSession('user');
        if ($user && array_key_exists('id', $user)) {
            $isOwner = $userId == $user['id'];
        }
        view('post/read', array_merge(
            compact('username', 'title', 'isOwner', 'user'),
            [
                'content'   => $content,
                'createdAt' => getPostCreatedAt($createdAt),
                'update'    => "/post/update.php?id=" . $id
            ]
        ));
        echo go(
            array_merge(
                compact('id'),
                [
                    'token' => getSession('CSRF_TOKEN')
                ]
            ),
            pipe('jsVar')
        );
        return http_response_code(200);
    }
    return http_response_code(404);
}

/**
 * Update for Post informations (PATCH)
 */
function updatePost($conn, $user)
{
    [
        'title'     => $title,
        'content'   => $content,
        'token'     => $token
    ] = getParamsWithFilters([
        'params' => getInputParams('patch'),
        'filterMappings' => [
            'title' => [ FILTER_SANITIZE_FULL_SPECIAL_CHARS ]
        ]
    ]);

    [ 'id' => $id ] = getParamsWithFilters([
        'params' => getInputParams('get'),
        'filterMappings' => [
            'id'    => [ FILTER_VALIDATE_INT ]
        ]
    ]);

    if ($id && $title && $content && verity($token, getSession('CSRF_TOKEN'))) {
        [ 'user_id' => $userId ] = get(
            $conn,
            'posts',
            'first',
            [
                'wheres' => [ 'id' ]
            ],
            $id
        );
        if ($user['id'] == $userId) {
            $is = patch($conn, 'posts', $id, [
                'title'     => $title,
                'content'   => removeTags($content, 'script')
            ]);
            if ($is) {
                history('info', 'Post::update:: Successful', [ $id ]);
                return header("Location: /post/?id=" . $id);
            }
        }
    }
    history('info', 'Post::update:: Failed', [ $id ]);
    return header("Location: /post/update.php?id=" . $id);
}

/**
 * Delete a Post (DELETE)
 */
function deletePost($conn, $user)
{
    [ 'token' => $token ] = getParamsWithFilters([
        'params' => getInputParams('delete'),
        'filterMappings' => [
            'token' => [ FILTER_SANITIZE_STRING ]
        ]
    ]);

    [ 'id' => $id ] = getParamsWithFilters([
        'params' => getInputParams('get'),
        'filterMappings' => [
            'id'    => [ FILTER_VALIDATE_INT ]
        ]
    ]);

    if ($id && verity($token, getSession('CSRF_TOKEN'))) {
        [ 'user_id' => $userId ] = get($conn, 'posts', 'first', [ 'wheres' => [ 'id' ] ], $id);
        if ($user['id'] == $userId) {
            $is = remove($conn, 'posts', $id);
            if ($is) {
                history('info', 'Post::delete:: Successful', [ $id ]);
                return http_response_code(204);
            }
        }
    }
    history('info', 'Post::delete:: Failed', [ $id ]);
    return http_response_code(400);
}
