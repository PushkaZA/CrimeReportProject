<?php
// Development: make mysqli throw exceptions on errors to surface problems early
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host =  "localhost";
$username = "root";
$password = "";
$dbname = "crimeprojectdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use utf8mb4 by default
$conn->set_charset('utf8mb4');

?>