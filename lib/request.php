<?php

/**
 * get Input parameters with Filters
 *
 * @param array $options
 *
 * @return array
 */
function getParamsWithFilters($options)
{
    [
        'params'         => $params,
        'filterMappings' => $filterMappings
    ] = $options;

    $inputs = [];
    foreach ($params as $key => $param) {
        $filters = array_key_exists($key, $filterMappings) ? $filterMappings[$key] : [];
        $inputs[$key] = param($param, $filters);
    }
    return $inputs;
}

/**
 * get Input params
 *
 * @param string $method
 *
 * @return array
 */
function getInputParams($method)
{
    switch (strtoupper($method)) {
        case 'PATCH':
        case 'PUT':
        case 'DELETE':
            if (isset($_POST) && array_key_exists('_method', $_POST)) {
                return $_POST;
            }
            return json_decode(file_get_contents('php://input'), true);
        case 'POST':
            return $_POST;
        default:
            return $_GET;
    }
}

/**
 * get Reqeust method
 *
 * @return string
 */
function getRequestMethod()
{
    if (isset($_POST['_method'])) {
        return strtoupper(param($_POST['_method'], [ FILTER_SANITIZE_STRING ]));
    }
    return $_SERVER['REQUEST_METHOD'];
}

/**
 * get variable with filters
 *
 * @param $var
 * @param $filters
 *
 * @return mixed|null
 */
function param($var, $filters = [])
{
    return filter_var($var, ...$filters) ?: null;
}
