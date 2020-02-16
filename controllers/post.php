<?php

/**
 * Write Form for a new Post (GET)
 */
function showStoreForm()
{
    return view('post', [
        'requestUrl' => '/post/write.php'
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

        if ($is = execute('INSERT INTO posts(user_id, title, content, created_at) VALUES (?, ?, ?, ?)', ...array_values($args))) {
            header('Location: /');
            return $is;
        }
        header('Location: /post/write.php');
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
        [ 'username' => $username ] = current(rows('SELECT * FROM users WHERE id = ?', $post['user_id']));
        return view('read', compact('post', 'id', 'username'));
    }
    http_response_code(404);
}

/**
 * Update Form for Post informations (GET)
 *
 * @param int $id
 */
function showUpdateForm($id)
{
    if ($post = __exists($id)) {
        return owner($id) && view('post', array_merge($post, [
            'requestUrl' => '/post/update.php?id=' . $id
        ]));
    }
    http_response_code(404);
}

/**
 * Update for Post informations (POST)
 *
 * @param int $id
 */
function update($id)
{
    return __post(function ($args) use ($id) {
        $args['id'] = $id;
        if ($is = (owner($id) && execute('UPDATE posts SET title = ?, content = ? WHERE id = ?', ...array_values($args)))) {
            header('Location: /post/read.php?id=' . $id);
            return $is;
        }
        header('Location: /post/update.php?id=' . $id);
    });
}

/**
 * Delete a Post (GET)
 *
 * @param int $id
 */
function destory($id)
{
    if ($is = (owner($id) && execute('DELETE FROM posts WHERE id = ?', $id))) {
        header('Location: /');
        return $is;
    }
    header('Location: /post/read.php?id=' . $id);
}

/**
 * @return mixed
 */
function __exists($id)
{
    $post = rows('SELECT * FROM posts WHERE id = ? LIMIT 1', $id);
    if (count($post) < 1) {
        return false;
    }
    return current($post);
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
    if (count($args) == count(array_filter($args))) {
        return call_user_func($callback, $args);
    }
    http_response_code(400);
}
