<?php

/**
 * Response with Vue component
 *
 * @param string $component
 * @param array $args
 *
 * @return void
 */
function component($component, $args = [])
{
    $componentString = "<component is='{$component}'";
    foreach ($args as $name => $value) {
        $componentString .= " {$name} = '{$value}'";
    }
    $componentString .= "></component>";

    return require_once dirname(__DIR__) . "/resources/views/app.php";
}
