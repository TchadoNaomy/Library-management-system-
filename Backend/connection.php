<?php
// Remove session_start() from here since it will be handled in session_checker.php
require_once 'config.php';

// Create error log directory if it doesn't exist
$logDir = __DIR__ . '/logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0777, true);
}

$conn = new mysqli($hostname, $servername, $password, $dbname);

if ($conn->connect_error) {
    $errorMessage = "Connection failed: " . $conn->connect_error;
    error_log($errorMessage, 3, $logDir . '/error.log');
    die("Connection failed: " . $conn->connect_error);
}
?>