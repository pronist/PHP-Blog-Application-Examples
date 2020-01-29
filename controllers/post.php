<?php

/**
 * Get posts (GET)
 */
function getPosts()
{
    $page = $_GET['page'] ?? $_GET['page'] = 0;

    $posts = transform(get('posts', 'all', [
        'orderBy' => [ 'id' => 'DESC' ],
        'limit'   => 3,
        'offset'  => $page * 3
    ]));
    echo json_encode($posts);

    return $posts;
}

/**
 * Write Form for a new Post (GET)
 */
function showWriteForm()
{
    setSession('CSRF_TOKEN', getToken());
    $user = user();

    return component('app-post-form', [
        'token'      => getSession('CSRF_TOKEN'),
        'request_url' => '/post'
    ]);
}

/**
 * Write a new Post (POST)
 */
function createNewPost()
{
    $user = user();

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
        $is = create('posts', [
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
    return header("Location: /post/write");
}


/**
 * Get posts (GET)
 */
function showPost($id)
{
    setSession('CSRF_TOKEN', getToken());
    $user = user();

    [
        'user_id'       => $userId,
        'title'         => $title,
        'content'       => $content,
        'created_at'    => $createdAt
    ] = get('posts', 'first', [ 'wheres' => [ 'id' ] ], $id);

    if ($userId) {
        [
            'username'      => $username,
            'email'         => $email
        ] = get('users', 'first', [ 'wheres' => [ 'id' ] ], $userId);
    }

    if ($userId && $title && $content && $createdAt) {
        $is_owner = $userId == $user['id'];
        component('app-read', array_merge(
            compact('username', 'title', 'is_owner', 'id'),
            [
                'content'       => param($content, [ FILTER_SANITIZE_SPECIAL_CHARS ]),
                'created_at'    => getPostCreatedAt($createdAt),
                'update'        => "/post/update/" . $id,
                'token'         => getSession('CSRF_TOKEN')
            ]
        ));
        return http_response_code(200);
    }
    http_response_code(404);
}

/**
 * Update Form for Post informations (GET)
 */
function showPostUpdateForm($id)
{
    setSession('CSRF_TOKEN', getToken());
    $user = user();

    [
        'title'     => $title,
        'content'   => $content
    ] = get('posts', 'first', [ 'wheres' => [ 'id' ] ], $id);

    return component('app-post-form', array_merge(
        compact('id', 'title'),
        [
            'content'       => param($content, [ FILTER_SANITIZE_FULL_SPECIAL_CHARS ]),
            'token'         => getSession('CSRF_TOKEN'),
            'request_url'   => '/post/' . $id,
            'method'        => 'patch'
        ]
    ));
}

/**
 * Update for Post informations (PATCH)
 */
function updatePost($id)
{
    $user = user();

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

    if ($id && $title && $content && verity($token, getSession('CSRF_TOKEN'))) {
        [ 'user_id' => $userId ] = get('posts', 'first', [ 'wheres' => [ 'id' ] ], $id);
        if ($user['id'] == $userId) {
            $is = patch('posts', $id, [
                'title'     => $title,
                'content'   => removeTags($content, 'script')
            ]);
            if ($is) {
                history('info', 'Post::update:: Successful', [ $id ]);
                return header("Location: /post/" . $id);
            }
        }
    }
    history('info', 'Post::update:: Failed', [ $id ]);
    return header("Location: /post/update/" . $id);
}

/**
 * Delete a Post (DELETE)
 */
function deletePost($id)
{
    $user = user();

    [ 'token' => $token ] = getParamsWithFilters([
        'params' => getInputParams('delete'),
        'filterMappings' => [
            'token' => [ FILTER_SANITIZE_STRING ]
        ]
    ]);

    if ($id && verity($token, getSession('CSRF_TOKEN'))) {
        [ 'user_id' => $userId ] = get('posts', 'first', [ 'wheres' => [ 'id' ] ], $id);
        if ($user['id'] == $userId) {
            $is = remove('posts', $id);
            if ($is) {
                history('info', 'Post::delete:: Successful', [ $id ]);
                return http_response_code(204);
            }
        }
    }
    history('info', 'Post::delete:: Failed', [ $id ]);
    return http_response_code(400);
}
