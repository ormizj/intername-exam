<?php

require_once __DIR__ . '/../config.php';
function init_header($methodType, $isAuth = false)
{
    global $CORS_ORIGIN;

    header('Access-Control-Allow-Origin:' . $CORS_ORIGIN);
    header('Content-Type: application/json');
    header('Access-Control-Allow-Method: ' . $methodType);
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Request-With' . ($isAuth ? ', Authorization' : ''));
}

function header_200($message = null)
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 200 OK';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

function header_404($message = null)
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

function header_405($message = null)
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 405 Method Not Allowed';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

function header_409($message = null)
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 409 Conflict';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

function header_422($message = null)
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 422 Unprocessable Content';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

function header_500($message = null)
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}