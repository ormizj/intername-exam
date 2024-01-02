<?php

// init header and methodType
require_once __DIR__ . '/../../utils/header.php';
$methodType = 'PUT';
init_header($methodType, true);

require_once __DIR__ . '/../../utils/request.php';
require_once __DIR__ . '/../../model/leads.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod != $methodType) {
    echo method_not_allowed();
    return;
}

$bodyData = get_body_data();
$result = mark_lead_as_called($bodyData['id']);
echo json_encode($result);