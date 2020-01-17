<?php

/**
 * Delete a User Session (POST)
 */
function logout()
{
    return destroySession();
}
