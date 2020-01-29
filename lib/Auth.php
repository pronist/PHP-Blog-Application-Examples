<?php

/**
 * Guard
 *
 * @return bool
 */
function guard()
{
    if (getSession('user')) {
        return true;
    }
    return header('Location: /auth/login');
}


/**
 * get User
 *
 * @return bool|array
 */
function user()
{
    return getSession('user');
}
