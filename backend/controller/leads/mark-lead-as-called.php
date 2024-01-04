<?php

// init header and methodType
require_once __DIR__ . '/../../utils/header.php';
$methodType = 'POST';
init_header($methodType, true);

require_once __DIR__ . '/../../utils/request.php';
require_once __DIR__ . '/../../services/leads.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod != $methodType) {
    echo json_encode(method_not_allowed());
    return;
}

$data = get_body_data();
$result = mark_lead_as_called($data['id']);
echo json_encode($result);