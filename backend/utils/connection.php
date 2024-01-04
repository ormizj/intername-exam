<?php

require_once __DIR__ . '/../config.php';

global $SQL_HOST;
global $SQL_USER;
global $SQL_PASS;
global $SQL_DATABASE;

$conn = new mysqli($SQL_HOST, $SQL_USER, $SQL_PASS, $SQL_DATABASE);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
