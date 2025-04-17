<?php
require_once '../connection.php';
session_start();

header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    // Debug: Log received data
    error_log("Received POST data: " . print_r($_POST, true));
    error_log("Received FILES data: " . print_r($_FILES, true));

    // Validate required fields
    $requiredFields = ['title', 'author', 'publisher', 'publication_date', 'ISBN', 'quantity'];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Sanitize and validate inputs
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $publisher = htmlspecialchars($_POST['publisher']);
    
    // Convert and validate publication date
    $publication_date = DateTime::createFromFormat('Y-m-d', $_POST['publication_date']);
    if (!$publication_date) {
        throw new Exception('Invalid publication date format');
    }
    $publication_date = $publication_date->format('Y-m-d');

    $ISBN = htmlspecialchars($_POST['ISBN']);
    $quantity = intval($_POST['quantity']);
    
    // Format current date for added_date
    $arrival_date = date('Y-m-d');

    // Handle book cover upload
    $book_cover = null;

    if (isset($_FILES['book_cover']) && $_FILES['book_cover']['error'] === UPLOAD_ERR_OK) {
        // Debug: Log file information
        error_log("Processing file upload: " . print_r($_FILES['book_cover'], true));

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $file_type = mime_content_type($_FILES['book_cover']['tmp_name']);
        
        if (!in_array($file_type, $allowed_types)) {
            throw new Exception('Invalid file type. Only JPG, JPEG & PNG files are allowed.');
        }

        // Validate file size (max 5MB)
        if ($_FILES['book_cover']['size'] > 5 * 1024 * 1024) {
            throw new Exception('File is too large. Maximum size is 5MB.');
        }

        // Read file content
        $book_cover = file_get_contents($_FILES['book_cover']['tmp_name']);
    }

    // Debug: Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "INSERT INTO books (book_cover,title, author, publisher, publication_date, ISBN, quantity, added_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    if (!$stmt->bind_param("sssssibs", 
        $book_cover,
        $title,
        $author,
        $publisher,
        $publication_date,
        $ISBN,
        $quantity,
        $arrival_date
    )) {
        throw new Exception("Binding parameters failed: " . $stmt->error);
    }    
    
    // Execute statement
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Book added successfully',
        'book_id' => $stmt->insert_id
    ]);

    $stmt->close();

} catch (Exception $e) {
    error_log("Error adding book: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
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