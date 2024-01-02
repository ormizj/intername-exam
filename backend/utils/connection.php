<?php

require_once __DIR__ . '/../config.php';

$conn = new mysqli($SQL_HOST, $SQL_USER, $SQL_PASS, $SQL_DATABASE);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
