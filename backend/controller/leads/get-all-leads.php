<?php

// init header and methodType
require_once __DIR__ . '/../../utils/header.php';
$methodType = 'GET';
init_header($methodType, true);

require_once __DIR__ . '/../../utils/request.php';
require_once __DIR__ . '/../../services/leads.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod != $methodType) {
    echo method_not_allowed();
    return;
}

$result = get_all_leads();
echo json_encode($result);