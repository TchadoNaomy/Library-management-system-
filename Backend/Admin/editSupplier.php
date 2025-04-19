<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'library_management';

// Create connection with error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    throw new Exception("Connection failed: " . $conn->connect_error);
}

debugLog('Database connected');

$supplierId = intval($_POST['supplier_id']);
debugLog('Processing supplier ID', $supplierId);

// Debug logging
function debugLog($message, $data = null) {
    error_log(sprintf(
        "[Debug] %s - Data: %s", 
        $message, 
        $data ? json_encode($data) : 'none'
    ));
}

// Prevent any output buffering issues
while (ob_get_level()) ob_end_clean();

// Set strict error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Set proper headers
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

try {
    debugLog('Request started', $_POST);

    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. Expected POST, got ' . $_SERVER['REQUEST_METHOD']);
    }

    // Validate required fields
    $required_fields = ['supplier_id', 'name', 'email', 'phone_number', 'address'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Sanitize inputs
    $supplierId = intval($_POST['supplier_id']);
    $name = trim($_POST['name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone_number']);
    $address = trim($_POST['address']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    // Check if email exists for other suppliers
    $checkEmail = $conn->prepare("SELECT supplier_id FROM supplier WHERE email = ? AND supplier_id != ?");
    $checkEmail->bind_param("si", $email, $supplierId);
    $checkEmail->execute();
    if ($checkEmail->get_result()->num_rows > 0) {
        throw new Exception('Email already exists for another supplier');
    }
    $checkEmail->close();

    // Update supplier information
    $stmt = $conn->prepare("
        UPDATE supplier 
        SET name = ?, 
            email = ?, 
            phone_number = ?, 
            address = ?
        WHERE supplier_id = ?
    ");

    if (!$stmt) {
        throw new Exception("Query preparation failed");
    }

    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $supplierId);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to update supplier");
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception("No changes made or supplier not found");
    }

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Supplier updated successfully',
        'supplier' => [
            'supplier_id' => $supplierId,
            'name' => htmlspecialchars($name),
            'email' => htmlspecialchars($email),
            'phone_number' => htmlspecialchars($phone),
            'address' => htmlspecialchars($address)
        ]
    ]);

} catch (Exception $e) {
    debugLog('Error occurred', ['message' => $e->getMessage()]);
    
    $errorResponse = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    
    http_response_code(400);
    echo json_encode($errorResponse);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
