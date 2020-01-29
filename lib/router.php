<?php

/**
 * set Routes
 *
 * @param array $routes
 *
 * @return void
 */
function setRoutes($routes)
{
    foreach ($routes as $group => $_routes) {
        foreach ($_routes as $route) {
            [ $path, $method, $callback, $middlewares ] = $route;

            $path = $path != '/' ? $group . $path : $group;
            $controller = implode('.', [
                $group != '/' ? substr($group, 1, strlen($group)) : 'index',
                $callback
            ]);
            if (route($method, $path, $controller, $middlewares)) {
                return;
            }
        }
    }
    return http_response_code(404);
}

/**
 * Register route.
 *
 * @param string $method
 * @param string $path
 * @param string $controller
 *
 * @return bool
 */
function route($method, $path, $controller, $middlewares = [])
{
    $requestUrl = current(explode('?', $_SERVER['REQUEST_URI']));
    $request = getRequestMethod();

    $urlParts = array_slice(explode('/', $requestUrl), 1);

    $params = [];
    foreach (array_slice(explode('/', $path), 1) as $idx => $part) {
        if (!array_key_exists($idx, $urlParts)) {
            break;
        }
        if (preg_match('/^\{.*?\}$/', $part)) {
            $path = str_replace($part, $urlParts[$idx], $path);
            array_push($params, $urlParts[$idx]);
        }
        if ($path == $requestUrl && $request == strtoupper($method)) {
            return controller($controller, $params, $middlewares);
        }
    }
    return false;
}

/**
 * Run controller.
 *
 * @param string $controller
 *
 * @return bool
 */
function controller($controller, $params, $middlewares = [])
{
    if (is_callable($controller)) {
        $callback = $controller;
    } else {
        [ $file, $callback ] = explode('.', $controller);
        include_once dirname(__DIR__) . '/controllers/' . $file . '.php';
    }
    if (middleware($middlewares)) {
        call_user_func($callback, ...$params);
        return true;
    }
    return false;
}

/**
 * Run middlewares.
 *
 * @param array $middlewares
 *
 * @return bool
 */
function middleware($middlewares)
{
    $is = false;
    foreach ($middlewares as $middleware) {
        $is = call_user_func($middleware);
        if (!$is) {
            return $is;
        }
    }
    return true;
}
