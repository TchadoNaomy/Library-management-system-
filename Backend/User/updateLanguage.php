<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['language'])) {
    echo json_encode(['success' => false, 'message' => 'Language not specified']);
    exit;
}

$language = $_POST['language'];
$allowedLanguages = ['en', 'fr', 'es'];

if (!in_array($language, $allowedLanguages)) {
    echo json_encode(['success' => false, 'message' => 'Invalid language']);
    exit;
}

// Store language preference in session
$_SESSION['language'] = $language;

// If user is logged in, update their preference in database
if (isset($_SESSION['user_id'])) {
    require_once '../connection.php';
    
    try {
        // Add language column if it doesn't exist
        $conn->query("ALTER TABLE user ADD COLUMN IF NOT EXISTS language_preference VARCHAR(2) DEFAULT 'en'");
        
        $stmt = $conn->prepare("UPDATE user SET language_preference = ? WHERE user_id = ?");
        $stmt->bind_param("si", $language, $_SESSION['user_id']);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Language preference updated']);
        } else {
            throw new Exception("Failed to update language preference");
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    } finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
} else {
    echo json_encode(['success' => true, 'message' => 'Language preference stored in session']);
}
?>