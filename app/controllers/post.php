<?php

/**
 * Write Form for a new Post (GET)
 */
function create()
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
    $args = filter_input_array(INPUT_POST, [
        'title'     => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'content'   => FILTER_DEFAULT
    ]);
    $args['created_at'] = date('Y-m-d H:i:s', time());
    $args = array_merge([ 'id' => $_SESSION['user']['id'] ], $args);

    if (createPost(...array_values($args))) {
        return header('Location: /');
    }
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}

/**
 * Read a Post by a post id (GET)
 *
 * @param int $id
 */
function show($id)
{
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($post = post($id)) {
        [ 'username' => $username ] = user($post['user_id']);
        return view('read', array_merge($post, compact('username')));
    }
    return header('HTTP/1.1 404 Not Found');
}

/**
 * Update Form for Post informations (GET)
 *
 * @param int $id
 */
function edit($id)
{
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($post = post($id)) {
        return owner($post['id']) && view('post', array_merge($post, [
            'requestUrl' => '/post/update?id=' . $post['id']
        ]));
    }
    return header('HTTP/1.1 404 Not Found');
}

/**
 * Update for Post informations (POST)
 *
 * @param int $id
 */
function update($id)
{
    $args = filter_input_array(INPUT_POST, [
        'title'     => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'content'   => FILTER_DEFAULT
    ]);
    $args['id'] = $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($post = post($id)) {
        if (owner($post['id']) && updatePost(...array_values($args))) {
            return header('Location: /post/read?id=' . $post['id']);
        }
        return header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    return header('HTTP/1.1 404 Not Found');
}

/**
 * Delete a Post (GET)
 *
 * @param int $id
 */
function destory($id)
{
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($post = post($id)) {
        if (owner($post['id']) && deletePost($post['id'])) {
            return header('Location: /');
        }
        return header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    return header('HTTP/1.1 404 Not Found');
}
