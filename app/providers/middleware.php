<?php

/**
 * Middlewares
 */

return function () {
    $middlewares = [
        'auth',
        'csrfToken',
        'require'
    ];
    foreach ($middlewares as $file) {
        assert(require_once dirname(__DIR__) . "/middlewares/{$file}.php");
    }
    return true;
};
