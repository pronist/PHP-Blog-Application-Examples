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
function create()
{
    return user(
        'INSERT INTO users(email, password, username) VALUES(?, ?, ?)',
        '/auth/login.php',
        '/user/register.php'
    );
}

/**
 * Update Form for User informations (GET)
 */
function showUpdateForm()
{
    return view('auth', [
        'requestUrl' => '/user/update.php'
    ]);
}

/**
 * Update User informations (POST)
 *
 * @param int $id
 */
function update($id)
{
    return user(
        'UPDATE users SET email = ?, password = ?, username = ? WHERE id = ?',
        '/auth/login.php',
        '/user/update.php',
        $id
    );
}
