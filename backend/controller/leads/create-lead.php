<?php

// init header and methodType
require_once __DIR__ . '/../../utils/header.php';
$methodType = 'POST';
init_header($methodType);

require_once __DIR__ . '/../../utils/request.php';
require_once __DIR__ . '/../../model/leads.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod != $methodType) {
    echo method_not_allowed();
    return;
}

$bodyData = get_body_data();
$result = create_lead($bodyData);
var_dump(json_encode($result));