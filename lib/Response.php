<?php

/**
 * Response with view
 *
 * @param string $view
 * @param array $args
 *
 * @return void
 */
function view($view, $args = [])
{
    foreach ($args as $name => $value) {
        $$name = $value;
    }
    return include dirname(__DIR__) . "/views/" . $view . ".php";
}
