<?php

require_once __DIR__ . '/../config.php';

/**
 * @param $methodType string what method type the request should expect (E.G. "GET")
 * @param $isAuth bool {true} if to add the "Authorization" option into the header
 * @return void
 */
function init_header(string $methodType, bool $isAuth = false): void
{
    global $CORS_ORIGIN;

    header('Access-Control-Allow-Origin:' . $CORS_ORIGIN);
    header('Content-Type: application/json');
    header('Access-Control-Allow-Method: ' . $methodType);
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Request-With' . ($isAuth ? ', Authorization' : ''));
}

/**
 * @param $message string|null to append in the header
 * @return void
 */
function header_200(string $message = null): void
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 200 OK';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

/**
 * @param $message string|null to append in the header
 * @return void
 */
function header_401(string $message = null): void
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 401 Unauthorized';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

/**
 * @param $message string|null to append in the header
 * @return void
 */
function header_404(string $message = null): void
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

/**
 * @param $message string|null to append in the header
 * @return void
 */
function header_405(string $message = null): void
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 405 Method Not Allowed';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

/**
 * @param $message string|null to append in the header
 * @return void
 */
function header_409(string $message = null): void
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 409 Conflict';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

/**
 * @param $message string|null to append in the header
 * @return void
 */
function header_422(string $message = null): void
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 422 Unprocessable Content';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}

/**
 * @param $message string|null to append in the header
 * @return void
 */
function header_500(string $message = null): void
{
    $headerMsg = $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error';
    if (isset($message)) {
        $headerMsg .= ' - ' . $message;
    }
    header($headerMsg);
}