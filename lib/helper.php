<?php

/**
 * Check params
 *
 * @param array $params
 *
 * @return bool
 */
function check($params)
{
    foreach ($params as $arg) {
        if (!$arg) {
            return false;
        }
    }
    return true;
}

/**
 * View
 */
function view($view, $vars = [])
{
    foreach ($vars as $name => $value) {
        $$name = $value;
    }
    require_once dirname(__DIR__) . '/views/layouts/app.php';
}
