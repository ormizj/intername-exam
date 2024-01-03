<?php

// init header and methodType
require_once __DIR__ . '/../../utils/header.php';
$methodType = 'POST';
init_header($methodType);

require_once __DIR__ . '/../../utils/request.php';
require_once __DIR__ . '/../../services/leads.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod != $methodType) {
    echo method_not_allowed();
    return;
}

$data = get_body_data();
$data['url'] = $_SERVER['HTTP_REFERER']; // declare full url (unsure if this is what was requested in terms of the lead url)
$result = create_lead($data);
echo json_encode($result);