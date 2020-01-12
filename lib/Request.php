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
    list(
        'params'         => $params,
        'filterMappings' => $filterMappings
    ) = $options;

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
    return strtoupper(filter_input(INPUT_POST, '_method', FILTER_SANITIZE_STRING)) ?: $_SERVER['REQUEST_METHOD'];
}

/**
 * Upload a file
 *
 * @param array $file
 * @param string $path
 *
 * @codeCoverageIgnore
 *
 * @return bool
 */
function upload($file, $path)
{
    if (is_uploaded_file($file['tmp_name'])) {
        return move_uploaded_file($file['tmp_name'], $path);
    }
    return false;
}

/**
 * get variable with filters
 *
 * @param $method
 * @param $name
 * @param $filters
 *
 * @return mixed|null
 */
function param($method, $filters = [])
{
    return filter_var($method, ...$filters) ?: null;
}
