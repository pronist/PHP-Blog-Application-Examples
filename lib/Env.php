<?php

/**
 * set Environment Variables
 *
 * @param int|string $key
 * @param mixed $value
 *
 * @return mixed
 */
function setEnv($key, $value)
{
    return $_ENV[$key] = $value;
}

/**
 * get Environment Variables
 *
 * @param int|string $key
 *
 * @return mixed
 */
function env($key)
{
    if (array_key_exists($key, $_ENV)) {
        return $_ENV[$key];
    }
    return null;
}
