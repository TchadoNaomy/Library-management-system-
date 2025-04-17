<?php
require_once '../connection.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['user_id']) || !isset($_POST['role'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit;
}

try {
    $userId = intval($_POST['user_id']);
    $newRole = $_POST['role'];
    
    // Validate role - only allow client and admin
    $allowedRoles = ['admin', 'client'];
    if (!in_array($newRole, $allowedRoles)) {
        echo json_encode(['success' => false, 'message' => 'Invalid role. Role must be either client or admin']);
        exit;
    }
    
    // Prevent admin from modifying their own role
    if ($_SESSION['user_id'] == $userId) {
        echo json_encode(['success' => false, 'message' => 'Cannot modify your own role']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE user SET role = ? WHERE user_id = ?");
    $stmt->bind_param("si", $newRole, $userId);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'success' => true, 
                'message' => 'User role updated successfully to ' . $newRole,
                'newRole' => $newRole
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    error_log("Error updating user: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>