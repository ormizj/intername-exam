<?php

// init header and methodType
require_once __DIR__ . '/../../utils/header.php';
$methodType = 'GET';
init_header($methodType, true);

require_once __DIR__ . '/../../utils/request.php';
require_once __DIR__ . '/../../services/leads.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod != $methodType) {
    echo json_encode(method_not_allowed());
    return;
}

$data = get_param_data();
$result = get_lead_by_id($data['id']);
echo json_encode($result);