<?php

/**
 * Write Form for a new Post (GET)
 */
function create()
{
    return view('post', [ 'requestUrl' => '/post/write' ]);
}

/**
 * Write a new Post (POST)
 */
function store()
{
    return __post(function ($_, $args) {
        $args = [
            'id'            => user()['id'],
            'title'         => $args['title'],
            'content'       => $args['content'],
            'created_at'    => date('Y-m-d H:i:s', time())
        ];
        return createPost(...array_values($args)) && redirect('/');
    });
}

/**
 * Read a Post by a post id (GET)
 *
 * @param int $id
 */
function show($id)
{
    return __post(function ($post) {
        [ 'username' => $username ] = selectOne('users', $post['user_id']);
        return view('read', array_merge($post, compact('username')));
    }, $id);
}

/**
 * Update Form for Post informations (GET)
 *
 * @param int $id
 */
function edit($id)
{
    return __post(function ($post) {
        return owner($post['id']) && view('post', array_merge($post, [
            'requestUrl' => '/post/update?id=' . $post['id']
        ]));
    }, $id);
}

/**
 * Update for Post informations (POST)
 *
 * @param int $id
 */
function update($id)
{
    return __post(function ($post, $args) {
        $args = array_merge($args, [ 'id' => $post['id'] ]);
        return owner($post['id']) &&
            updatePost(...array_values($args)) &&
            redirect('/post/read?id=' . $post['id'])
        ;
    }, $id);
}

/**
 * Delete a Post (GET)
 *
 * @param int $id
 */
function destory($id)
{
    return __post(function ($post) {
        return owner($post['id']) && deletePost($post['id']) && redirect('/');
    }, $id);
}

/**
 * @param callback $callback
 * @param int $id
 *
 * @return bool|void
 */
function __post($callback, $id = null)
{
    $args = filter_input_array(INPUT_POST, [
        'title'     => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'content'   => FILTER_DEFAULT
    ]);
    if ($id) {
        $post = selectOne('posts', filter_var($id, FILTER_VALIDATE_INT));
        if (empty($post)) {
            return reject(404);
        }
    }
    return call_user_func($callback, $post ?? [], $args) ?: reject();
}
