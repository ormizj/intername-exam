<?php

require_once __DIR__ . '/../utils/header.php';

/**
 * @return array of the client's params
 */
function get_param_data(): array
{
    return $_GET;
}

/**
 * @return array of the client's request body
 */
function get_body_data(): array
{
    $json = file_get_contents('php://input');
    return json_decode($json, true);
}

/**
 * @return array of a resolved request
 */
function method_not_allowed(): array
{
    $res = [
        'success' => false,
        'status' => 405,
        'message' => $_SERVER['REQUEST_METHOD'] . ' Method Not Allowed',
    ];

    header_405();
    return $res;
}

/**
 * response depicting a successful operation
 *
 * @param $status int HTTP response status codes
 * @param $data mixed that will return to the client
 * @return array of a resolved request
 */
function gen_success(int $status, mixed $data): array
{
    return [
        'success' => true,
        'status' => $status,
        'data' => $data,
    ];
}

/**
 * response depicting a failed operation
 *
 * @param $status int HTTP response status codes
 * @param $data mixed that will return to the client
 * @return array of a resolved request
 */
function gen_error(int $status, mixed $data): array
{
    return [
        'success' => false,
        'status' => $status,
        'data' => $data,
    ];
}