<?php
require_once '../connection.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['user_id']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit;
}

try {
    $userId = intval($_POST['user_id']);
    $action = $_POST['action']; // 'suspend' or 'unsuspend'
    
    // Prevent admin from modifying their own account
    if ($_SESSION['user_id'] == $userId) {
        echo json_encode(['success' => false, 'message' => 'Cannot modify your own account']);
        exit;
    }

    // Set the new role based on action
    $newRole = $action === 'suspend' ? 'suspended' : 'client';
    
    // Update user role
    $stmt = $conn->prepare("UPDATE user SET role = ? WHERE user_id = ?");
    $stmt->bind_param("si", $newRole, $userId);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'success' => true, 
                'message' => 'User has been ' . ($action === 'suspend' ? 'suspended' : 'restored as client'),
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
    error_log("Error modifying user status: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>