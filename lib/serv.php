<?php

/**
 * Login
 *
 * @param string $email
 */
function __login($email, $password)
{
    if ($user = first('SELECT * FROM users WHERE email = ? LIMIT 1', $email)) {
        if (password_verify($password, $user['password'])) {
            return $_SESSION['user'] = $user;
        }
    }
    return false;
}

/**
 * Logout
 */
function __logout()
{
    session_unset();
    return session_destroy();
}

/**
 * Upload
 *
 * @param string $file
 * @param array $accepts
 * @param string $filename
 */
function __upload($file, $accepts, $filename)
{
    $pathParts = pathinfo($file['name']);
    if (in_array(strtolower($pathParts['extension']), $accepts) && is_uploaded_file($file['tmp_name'])) {
        $path = dirname(__DIR__) . '/uploads/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $path)) {
            return json_encode([
                'uploaded'  => 1,
                'url'       => '/image?path=' . $filename
            ]);
        }
    }
    return null;
}

/**
 * Get a Image
 *
 * @param string $path
 */
function __image($path)
{
    if (file_exists($path)) {
        header("Content-type:" . mime_content_type($path));
        return file_get_contents($path);
    }
}

/**
 * Index
 *
 * @param int $page
 * @param int $count
 */
function __index($page, $count)
{
    if ($posts = rows("SELECT * FROM posts ORDER BY id DESC LIMIT {$count} OFFSET " .  $page * $count)) {
        return transform($posts);
    }
    return [];
}

/**
 * Store a post
 *
 * @param int $userId
 * @param string $title
 * @param string $content
 * @param string $createdAt
 */
function __storePost($userId, $title, $content, $createdAt)
{
    return execute('INSERT INTO posts(user_id, title, content, created_at) VALUES (?, ?, ?, ?)', $userId, $title, $content, $createdAt);
}

/**
 * Update a post
 *
 * @param string $title
 * @param string $content
 * @param int $id
 */
function __updatePost($title, $content, $id)
{
    return execute('UPDATE posts SET title = ?, content = ? WHERE id = ?', $title, $content, $id);
}

/**
 * Destory a post
 *
 * @param int $id
 */
function __destroyPost($id)
{
    return execute('DELETE FROM posts WHERE id = ?', $id);
}


/**
 * Store a user
 *
 * @param string $email
 * @param string $password
 * @param string $username
 */
function __storeUser($email, $password, $username)
{
    return execute('INSERT INTO users(email, password, username) VALUES(?, ? ,?)', $email, $password, $username);
}

/**
 * Update a user
 *
 * @param string $email
 * @param string $password
 * @param string $username
 * @param int $id
 */
function __updateUser($email, $password, $username, $id)
{
    return execute('UPDATE users SET email = ?, password = ?, username = ? WHERE id = ?', $email, $password, $username, $id);
}
