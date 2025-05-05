<?php
session_start();
header('Content-Type: application/json');

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'library_management';

try {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Please login to manage favorites');
    }

    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate book_id
    if (!isset($_POST['book_id']) || empty($_POST['book_id'])) {
        throw new Exception('Book ID is required');
    }

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION['user_id'];
    $bookId = intval($_POST['book_id']);

    // Check if already in favorites
    $checkStmt = $conn->prepare("SELECT fav_id FROM favourite WHERE user_id = ? AND book_id = ?");
    $checkStmt->bind_param("ii", $userId, $bookId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        // Remove from favorites
        $deleteStmt = $conn->prepare("DELETE FROM favourite WHERE user_id = ? AND book_id = ?");
        $deleteStmt->bind_param("ii", $userId, $bookId);
        
        if (!$deleteStmt->execute()) {
            throw new Exception("Failed to remove from favorites");
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Book removed from favorites'
        ]);
        
        $deleteStmt->close();
    } else {
        // Add to favorites
        $insertStmt = $conn->prepare("INSERT INTO favourite (user_id, book_id) VALUES (?, ?)");
        $insertStmt->bind_param("ii", $userId, $bookId);
        
        if (!$insertStmt->execute()) {
            throw new Exception("Failed to add to favorites");
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Book added to favorites successfully'
        ]);
        
        $insertStmt->close();
    }
    
    $checkStmt->close();

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>