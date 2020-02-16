<?php

/**
 * Register Form for a new User (GET)
 */
function showRegisterForm()
{
    return view('auth', [
        'requestUrl' => '/user/register.php'
    ]);
}

/**
 * Create a new User (POST)
 */
function store()
{
    return __user(function ($args) {
        return go(
            'INSERT INTO users(email, password, username) VALUES(?, ? ,?)',
            $args,
            '/auth/login.php',
            '/user/register.php'
        );
    });
}

/**
 * Update Form for User informations (GET)
 */
function showUpdateForm()
{
    return view('auth', [
        'requestUrl' => '/user/update.php',
        'email'      => $_SESSION['user']['email']
    ]);
}

/**
 * Update User informations (POST)
 *
 * @param int $id
 */
function update($id)
{
    return __exists($id) && __user(function ($args) use ($id) {
        $args['id'] = $id;

        return go(
            'UPDATE users SET email = ?, password = ?, username = ? WHERE id = ?',
            $args,
            '/auth/login.php',
            '/user/update.php'
        );
    });
}

/**
 * @return array|void
 */
function __exists($id)
{
    if ($user = first('SELECT * FROM users WHERE id = ? LIMIT 1', $id)) {
        return $user;
    }
    http_response_code(404);
}

/**
 * @param callback $callback
 *
 * @return void
 */
function __user($callback)
{
    $args = filter_input_array(INPUT_POST, [
        'email'     => FILTER_VALIDATE_EMAIL | FILTER_SANITIZE_EMAIL,
        'password'  => FILTER_SANITIZE_STRING
    ]);
    if (count($args) == count(array_filter($args))) {
        $args['username'] = current(explode('@', $args['email']));
        $args['password'] = password_hash($args['password'], PASSWORD_DEFAULT);

        if (call_user_func($callback, $args)) {
            session_unset();
            return session_destroy();
        }
    }
    http_response_code(400);
}
