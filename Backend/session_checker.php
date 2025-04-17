<?php
function checkSession() {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Prevent caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    
    // Check for session timeout (30 minutes)
    $timeout = 1800; // 30 minutes in seconds
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
        destroySession();
        header("Location: ../../Register.php?error=timeout");
        exit();
    }
    $_SESSION['last_activity'] = time();

    // Check if user is logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: ../../Register.php?error=auth");
        exit();
    }

    // Validate required session variables
    $required_vars = ['user_id', 'user_name', 'user_role'];
    foreach ($required_vars as $var) {
        if (!isset($_SESSION[$var])) {
            destroySession();
            header("Location: ../../Register.php?error=invalid");
            exit();
        }
    }

    // Check if user role matches the current directory
    $current_path = $_SERVER['PHP_SELF'];
    $is_admin_page = strpos($current_path, '/Admin/') !== false;
    $is_user_page = strpos($current_path, '/User/') !== false;

    if ($is_admin_page && $_SESSION['user_role'] !== 'admin') {
        header("Location: ../User/User.php");
        exit();
    }

    if ($is_user_page && $_SESSION['user_role'] !== 'user') {
        header("Location: ../Admin/Admin.php");
        exit();
    }

    // Regenerate session ID periodically to prevent session fixation
    if (!isset($_SESSION['last_regeneration']) || 
        (time() - $_SESSION['last_regeneration']) > 300) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

// Helper function to destroy session
function destroySession() {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
}
?>