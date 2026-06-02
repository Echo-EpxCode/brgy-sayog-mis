<?php

// ======================================
// DATABASE CONFIGURATION
// ======================================

$host = "localhost";
$user = "root";
$password = "";
$database = "barangay_sayog_mis";

// ======================================
// DATABASE CONNECTION
// ======================================

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
