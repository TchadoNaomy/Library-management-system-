<?php
header('Content-Type: application/json');

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'library_management';

try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate supplier_id
    if (!isset($_POST['supplier_id']) || empty($_POST['supplier_id'])) {
        throw new Exception('Supplier ID is required');
    }

    $supplierId = intval($_POST['supplier_id']);

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Check if supplier has associated orders
    $checkStmt = $conn->prepare("SELECT COUNT(*) as order_count FROM orders WHERE supplier_id = ?");
    $checkStmt->bind_param("i", $supplierId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $orderCount = $result->fetch_assoc()['order_count'];

    if ($orderCount > 0) {
        throw new Exception('Cannot delete supplier with existing orders');
    }

    // Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM supplier WHERE supplier_id = ?");
    if (!$stmt) {
        throw new Exception("Query preparation failed");
    }

    $stmt->bind_param("i", $supplierId);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to delete supplier");
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception("Supplier not found");
    }

    echo json_encode([
        'success' => true,
        'message' => 'Supplier deleted successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($checkStmt)) $checkStmt->close();
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
?>