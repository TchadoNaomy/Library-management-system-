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
        throw new Exception("Book ID is required");
    }

    $bookId = intval($_POST['book_id']);
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $publisher = htmlspecialchars($_POST['publisher']);
    $publication_date = $_POST['publication_date'];
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $quantity = intval($_POST['quantity']);

    // Handle book cover update if provided
    $updateCover = false;
    $book_cover = null;
    if (isset($_FILES['book_cover']) && $_FILES['book_cover']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/jfif'];
        if (!in_array($_FILES['book_cover']['type'], $allowed_types)) {
            throw new Exception('Invalid file type. Only JPG, JPEG & PNG files are allowed.');
        }
        
        if ($_FILES['book_cover']['size'] > 5 * 1024 * 1024) {
            throw new Exception('File is too large. Maximum size is 5MB.');
        }
        
        $book_cover = file_get_contents($_FILES['book_cover']['tmp_name']);
        $updateCover = true;
    }

    // Prepare SQL based on whether cover is being updated
    if ($updateCover) {
        $sql = "UPDATE books SET  book_cover=?, title=?, author=?, publisher=?, 
                publication_date=?, ISBN=?, quantity=? WHERE book_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssibi", 
        $book_cover, $title, $author, $publisher, $publication_date, 
            $ISBN, $quantity, $bookId);
    } else {
        $sql = "UPDATE books SET title=?, author=?, publisher=?, 
                publication_date=?, ISBN=?, quantity=? WHERE book_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssii", 
            $title, $author, $publisher, $publication_date, 
            $ISBN, $quantity, $bookId);
    }

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Book updated successfully'
        ]);
    } else {
        throw new Exception("Failed to update book");
    }

    $stmt->close();

} catch (Exception $e) {
    error_log("Error updating book: " . $e->getMessage());
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