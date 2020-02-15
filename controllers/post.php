<?php

/**
 * Write Form for a new Post (GET)
 */
function showCreateForm()
{
    return view('post', [
        'requestUrl' => '/post/write.php'
    ]);
}

/**
 * Write a new Post (POST)
 */
function create()
{
    $args = filter_input_array(INPUT_POST, [
        'title'     => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'content'   => FILTER_DEFAULT
    ]);
    array_unshift($args, $_SESSION['user']['id']);
    $args['created_at'] = date('Y-m-d H:i:s', time());
    return post(
        'INSERT INTO posts(user_id, title, content, created_at) VALUES (?, ?, ?, ?)',
        '/',
        '/post/write.php',
        filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING),
        ...array_values($args)
    );
}

/**
 * Read a Post by a post id (GET)
 *
 * @param int $id
 */
function show($id)
{
    $post = current(rows('SELECT * FROM posts WHERE id = ? LIMIT 1', $id));
    [ 'username' => $username ] = current(rows('SELECT * FROM users WHERE id = ?', $post['user_id']));

    return view('read', compact('post', 'id', 'username'));
}

/**
 * Update Form for Post informations (GET)
 *
 * @param int $id
 */
function showUpdateForm($id)
{
    if (owner($id)) {
        output_add_rewrite_var('id', $id);

        return view('post', array_merge(
            current(rows('SELECT * FROM posts WHERE id = ? LIMIT 1', $id)),
            [
                'requestUrl' => '/post/update.php?id=' . $id
            ]
        ));
    }
    return header('Location: /post/read.php?id=' . $id);
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
    if (owner($id)) {
        return post(
            'UPDATE posts SET title = ?, content = ? WHERE id = ?',
            '/post/read.php?id=' . $id,
            '/post/update.php?id=' . $id,
            filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING),
            ...array_values($args)
        );
    }

    return header('/post/read.php?id=' . $id);
}

/**
 * Delete a Post (GET)
 *
 * @param int $id
 */
function destory($id)
{
    if (owner($id)) {
        return post(
            'DELETE FROM posts WHERE id = ?',
            '/',
            '/post/read.php?id=' . $id,
            filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING),
            $id
        );
    }
    return header('/post/read.php?id=' . $id);
}
