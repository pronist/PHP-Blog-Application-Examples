<?php

return new Eclair\Application([
    \App\Providers\SessionServiceProvider::class,
    \App\Providers\RouteServiceProvider::class,
    \App\Providers\DatabaseServiceProvider::class,
    \App\Providers\ErrorServiceProvider::class,
    \App\Providers\ThemeServiceProvider::class
]);
