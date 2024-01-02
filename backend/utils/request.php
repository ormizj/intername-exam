<?php

require_once __DIR__ . '/../utils/header.php';

function get_body_data()
{
    $json = file_get_contents('php://input');
    return json_decode($json, true);
}

function method_not_allowed()
{
    $obj = [
        'success' => false,
        'status' => 405,
        'message' => $_SERVER['REQUEST_METHOD'] . ' Method Not Allowed',
    ];

    header_405();
    return json_encode($obj);
}

function gen_success($status, $data)
{
    return [
        'success' => true,
        'status' => $status,
        'data' => $data,
    ];
}

function gen_error($status, $data)
{
    return [
        'success' => false,
        'status' => $status,
        'data' => $data,
    ];
}