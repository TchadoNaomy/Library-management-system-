<?php
require_once '../connection.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    if (!isset($_POST['book_id'])) {
        throw new Exception('Book ID is required');
    }

    $bookId = intval($_POST['book_id']);

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM books WHERE book_id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $bookId);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Book deleted successfully'
        ]);
    } else {
        throw new Exception("Failed to delete book");
    }

    $stmt->close();

} catch (Exception $e) {
    error_log("Error deleting book: " . $e->getMessage());
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