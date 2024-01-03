<?php

// init header and methodType
require_once __DIR__ . '/../../utils/header.php';
$methodType = 'GET';
init_header($methodType, true);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../utils/request.php';
require_once __DIR__ . '/../../services/leads.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod != $methodType) {
    echo method_not_allowed();
    return;
}

// statically checking password
$data = get_param_data();
if ($data['username'] == $ADMIN_USER && $data['password'] == $ADMIN_PASS) {
    header_200();
    echo json_encode(gen_success(200, []));
} else {
    header_401();
    echo json_encode(gen_error(401, 'ADM-001'));
}