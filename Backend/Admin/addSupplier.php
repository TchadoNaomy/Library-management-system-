<?php
require_once '../connection.php';

header('Content-Type: application/json');

try {
    // Validate required fields
    $required_fields = ['name', 'email', 'phone_number', 'address'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            throw new Exception("Missing required field: " . str_replace('_', ' ', $field));
        }
    }

    // Sanitize inputs
    $name = trim($_POST['name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone_number']);
    $address = trim($_POST['address']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    // Validate phone number (minimum 10 digits)
    if (!preg_match('/^[+]?[0-9\s-]{10,}$/', $phone)) {
        throw new Exception('Please enter a valid phone number (minimum 10 digits)');
    }

    // Check for existing email
    $stmt = $conn->prepare("SELECT supplier_id FROM supplier WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        throw new Exception('A supplier with this email already exists');
    }
    $stmt->close();

    // Insert new supplier
    $stmt = $conn->prepare("INSERT INTO supplier (name, email, phone_number, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $address);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to add supplier: " . $stmt->error);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Supplier added successfully',
        'supplier_id' => $stmt->insert_id
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>