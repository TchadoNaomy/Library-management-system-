<?php
// Include necessary files
require_once __DIR__ . '/../connection.php';

// Get user data from session
$User = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$Email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
$Role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : '';

// Check if profile image is not already in session
if (!isset($_SESSION['profile_image'])) {
    try {
        // Get user profile image using email
        $imageQuery = "SELECT profile_image FROM user WHERE email = ?";
        $stmt = $conn->prepare($imageQuery);
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $imageResult = $stmt->get_result();
        
        if ($imageResult && $row = $imageResult->fetch_assoc()) {
            if ($row['profile_image']) {
                $_SESSION['profile_image'] = base64_encode($row['profile_image']);
            }
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log("Error fetching profile image: " . $e->getMessage());
    }
}

// Initialize counters
$userCount = 0;
$bookCount = 0;
$borrowCount = 0;
$pendingCount =0;

try {
    // Count users
    $userQuery = "SELECT COUNT(*) as total_users FROM user";
    $userResult = $conn->query($userQuery);
    if ($userResult) {
        $userCount = $userResult->fetch_assoc()['total_users'];
    }

    // Count books
    $bookQuery = "SELECT SUM(quantity) as total_books FROM books";
    $bookResult = $conn->query($bookQuery);
    if ($bookResult) {
        $bookCount = $bookResult->fetch_assoc()['total_books'];
    }

    // Count borrowed books
    $borrowQuery = "SELECT COUNT(*) as total_borrowed FROM borrowing_book";
    $borrowResult = $conn->query($borrowQuery);
    if ($borrowResult) {
        $borrowCount = $borrowResult->fetch_assoc()['total_borrowed'];
    }

    // count pending returns of books
    $pendingQuery = "SELECT COUNT(*) as total_pending FROM borrowing_book WHERE status = 'pending'";
    $pendingResult = $conn->query($pendingQuery);
    if ($pendingResult) {
        $pendingCount = $pendingResult->fetch_assoc()['total_pending'];
    }

} catch (Exception $e) {
    error_log("Error in dashboard counts: " . $e->getMessage());
}

// Close the connection
$conn->close();
?>