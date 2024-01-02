<?php

// init header and methodType
require_once __DIR__ . '/../../utils/header.php';
$methodType = 'GET';
init_header($methodType, true);

require_once __DIR__ . '/../../utils/request.php';
require_once __DIR__ . '/../../model/leads.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod != $methodType) {
    echo method_not_allowed();
    return;
}

$bodyData = get_param_data();
$result = get_leads_by_filter($bodyData);
var_dump(json_encode($result));