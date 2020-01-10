<?php

/**
 * get CSRF Toekn
 *
 * @return string
 */
function getToken()
{
    return bin2hex(random_bytes(32));
}

/**
 * verity CSRF Token
 *
 * @param string $user_token
 * @param string $toekn
 *
 * @return bool
 */
function verity($user_token, $token)
{
    return hash_equals($token, $user_token);
}
