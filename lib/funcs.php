<?php

/**
 * View
 *
 * @param string $view
 * @param array $vars
 *
 * @return mixed
 */
function view($view, $vars = [])
{
    foreach ($vars as $name => $value) {
        $$name = $value;
    }
    return require_once dirname(__DIR__) . '/views/layouts/app.php';
}

/**
 * is Owner
 *
 * @param int $id
 *
 * @return bool
 */
function owner($id)
{
    [ 'user_id' => $userId ] = first('SELECT * FROM posts WHERE id = ? LIMIT 1', $id);
    if (array_key_exists('user', $_SESSION)) {
        return $userId == $_SESSION['user']['id'];
    }
    return false;
}

/**
 * match
 *
 * @param string $path
 * @param string $method
 *
 * @return bool
 */
function hit($path, $method = null)
{
    $is = ($_SERVER['PATH_INFO'] ?? '/') == $path;
    if ($method) {
        $is = $is && strtoupper($method) == $_SERVER['REQUEST_METHOD'];
    }
    return $is;
}

/**
 * CSRF_TOKEN
 *
 * @param array $guards
 *
 * @return bool
 */
function verify($guards)
{
    foreach ($guards as [ $path, $method ]) {
        if (hit($path, $method)) {
            $token = array_key_exists('token', $_REQUEST) ? filter_var($_REQUEST['token'], FILTER_SANITIZE_STRING) : null;
            if (hash_equals($token, $_SESSION['CSRF_TOKEN'])) {
                return true;
            }
            return false;
        }
    }
    return true;
}

/**
 * Register auth guard
 *
 * @param array $guards
 *
 * @return bool
 */
function guard($guards)
{
    foreach ($guards as $path) {
        if (hit($path)) {
            if (array_key_exists('user', $_SESSION)) {
                return true;
            }
            return false;
        }
    }
    return true;
}

/**
 * Check request params
 *
 * @param array $requires
 *
 * @return bool
 */
function requires($requires)
{
    if (count($requires) == count(array_filter($requires))) {
        return true;
    }
    return false;
}

/**
 * set Routes
 *
 * @param array $routes
 *
 * @return void
 */
function routes($routes)
{
    foreach ($routes as [ $path, $method, $callbackString ]) {
        if (hit($path, $method)) {
            [ $file, $callback ] = explode('.', $callbackString);
            require_once dirname(__DIR__) . '/controllers/' . $file . '.php';
            call_user_func($callback, ...array_values($_GET));
            return true;
        }
    }
    return false;
}

/**
 * Transform posts
 *
 * @param array $posts
 */
function transform($posts)
{
    return array_map(function ($post) {
        [ 'username' => $username ] = user($post['user_id']);
        $content = filter_var(
            mb_substr(strip_tags($post['content']), 0, 200),
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        $mappings = array_merge(compact('username', 'content'), [
            'created_at' => date('h:i A, M j', strtotime($post['created_at'])),
            'url'        => "/post/read?id=" . $post['id']
        ]);
        return array_merge($post, $mappings);
    }, $posts);
}

/**
 * Get a post
 *
 * @param int $id
 */
function post($id)
{
    return first('SELECT * FROM posts WHERE id = ? LIMIT 1', $id);
}

/**
 * Get a user
 *
 * @param int $id
 */
function user($id)
{
    return first('SELECT * FROM users WHERE id = ? LIMIT 1', $id);
}
