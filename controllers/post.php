<?php

/**
 * Write Form for a new Post (GET)
 */
function showStoreForm() // create
{
    return view('post', [
        'requestUrl' => '/post/write'
    ]);
}

/**
 * Write a new Post (POST)
 */
function store()
{
    return __post(function ($args) {
        array_unshift($args, $_SESSION['user']['id']);
        $args['created_at'] = date('Y-m-d H:i:s', time());
        return go('INSERT INTO posts(user_id, title, content, created_at) VALUES (?, ?, ?, ?)', $args, '/');
    });
}

/**
 * Read a Post by a post id (GET)
 *
 * @param int $id
 */
function show($id)
{
    if ($post = __exists($id)) {
        [ 'username' => $username ] = first('SELECT * FROM users WHERE id = ? LIMIT 1', $post['user_id']);
        return view('read', compact('post', 'id', 'username'));
    }
}

/**
 * Update Form for Post informations (GET)
 *
 * @param int $id
 */
function showUpdateForm($id) // edit
{
    if ($post = __exists($id)) {
        return owner($id) && view('post', array_merge($post, [
            'requestUrl' => '/post/update?id=' . $id
        ]));
    }
}

/**
 * Update for Post informations (POST)
 *
 * @param int $id
 */
function update($id)
{
    return __exists($id) && owner($id) && __post(function ($args) use ($id) {
        $args['id'] = $id;
        return go('UPDATE posts SET title = ?, content = ? WHERE id = ?', $args, '/post/read?id=' . $id);
    });
}

/**
 * Delete a Post (GET)
 *
 * @param int $id
 */
function destory($id)
{
    return __exists($id) && owner($id) && go('DELETE FROM posts WHERE id = ?', [ $id ], '/');
}

/**
 * @return array|void
 */
function __exists($id)
{
    if ($post = first('SELECT * FROM posts WHERE id = ? LIMIT 1', $id)) {
        return $post;
    }
    http_response_code(404);
}

/**
 * @param callback $callback
 *
 * @return mixed
 */
function __post($callback)
{
    $args = filter_input_array(INPUT_POST, [
        'title'     => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'content'   => FILTER_DEFAULT
    ]);
    return call_user_func($callback, $args);
}
