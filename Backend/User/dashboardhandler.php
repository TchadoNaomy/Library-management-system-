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

// Close the connection
$conn->close();
?>