<?php
require_once '../connection.php';
session_start();

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User ID not provided']);
    exit;
}

try {
    $userId = intval($_POST['user_id']);
    
    // Check only for pending borrowed books
    $checkQuery = "SELECT COUNT(*) as pending_count FROM borrowing_book 
                  WHERE user_id = ? AND status = 'pending'";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $userId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $pendingCount = $result->fetch_assoc()['pending_count'];
    $checkStmt->close();

    if ($pendingCount > 0) {
        echo json_encode([
            'success' => false, 
            'message' => 'Cannot delete user. They have pending books that need to be returned first.'
        ]);
        exit;
    }

    // If no pending books, proceed with deletion
    $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    error_log("Error deleting user: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>