<?php
require_once 'config.php';

// Database configuration
// $hostname = 'localhost';
// $servername = 'root';
// $password = '';
// $dbname = 'library_management';

// Create error log directory if it doesn't exist
$logDir = __DIR__ . '/logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0777, true);
}

// Function to get a new connection
function getNewConnection() {
    global $hostname, $servername, $password, $dbname;
    $newConn = mysqli_connect($hostname, $servername, $password, $dbname);
    
    if (!$newConn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    mysqli_set_charset($newConn, 'utf8mb4');
    return $newConn;
}

// Maintain existing connection for backwards compatibility
$conn = getNewConnection();
?>