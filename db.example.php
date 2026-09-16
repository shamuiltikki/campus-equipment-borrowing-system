<?php

$host = "sql211.infinityfree.com";
$user = "if0_42932655";
$password = "YOUR_INFINITYFREE_PASSWORD";
$database = "if0_42932655_campus_equipment";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>