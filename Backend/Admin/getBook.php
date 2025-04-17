<?php
require_once '../connection.php';
session_start();

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Book ID is required']);
    exit;
}

try {
    $bookId = intval($_GET['id']);
    
    $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $bookId);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($book = $result->fetch_assoc()) {
            // Convert book cover to base64 if exists
            if ($book['book_cover']) {
                $book['book_cover'] = base64_encode($book['book_cover']);
            }
            
            echo json_encode([
                'success' => true,
                'book' => $book
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Book not found']);
        }
    } else {
        throw new Exception("Failed to fetch book details");
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    error_log("Error fetching book: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>