<?php
// Ensure no output before headers
ob_start();
session_start();
header('Content-Type: application/json');

// Clear any existing output buffers
while (ob_get_level()) {
    ob_end_clean();
}

try {
    require_once '../connection.php';
    
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Please login to update your profile picture');
    }

    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate file upload
    if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('No file uploaded or upload error occurred');
    }

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $_FILES['profile_image']['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime_type, $allowed_types)) {
        throw new Exception('Invalid file type. Only JPG, JPEG & PNG files are allowed.');
    }

    // Validate file size (5MB max)
    if ($_FILES['profile_image']['size'] > 5 * 1024 * 1024) {
        throw new Exception('File is too large. Maximum size is 5MB.');
    }

    $userId = $_SESSION['user_id'];
    $profile_image = file_get_contents($_FILES['profile_image']['tmp_name']);

    // Update user's profile image
    $stmt = $conn->prepare("UPDATE user SET profile_image = ? WHERE user_id = ?");
    $stmt->bind_param("bi", $profile_image, $userId);

    if (!$stmt->execute()) {
        throw new Exception("Failed to update profile picture: " . $stmt->error);
    }

    // Update session with new profile image
    $_SESSION['profile_image'] = base64_encode($profile_image);

    // Send success response
    echo json_encode([
        'success' => true,
        'message' => 'Profile picture updated successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}