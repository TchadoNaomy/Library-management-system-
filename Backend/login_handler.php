<?php
include_once 'connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize error messages array
$errors = array(
    'email' => '',
    'password' => '',
    'general' => ''
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty($_POST["logemail"])) {
        $errors['email'] = "Email is required";
    } else {
        $email = trim($_POST["logemail"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }

    // Validate password
    if (empty($_POST["logpassword"])) {
        $errors['password'] = "Password is required";
    }

    // If there are errors, store them in session
    if (array_filter($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: ../Register.php");
        exit();
    }

    // If no validation errors, proceed with login
    if (!array_filter($errors)) {
        try {
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT user_id, name, email, password, role FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // Check if account is suspended
                if ($user['role'] === 'suspended') {
                    $errors['general'] = "Your account has been suspended. Please contact the administrator.";
                }
                // Only verify password if account is not suspended
                else if (password_verify($_POST["logpassword"], $user['password'])) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['logged_in'] = true;

                    // Redirect based on role
                    if ($user['role'] === 'admin') {
                        header("Location: ../Dashboards/Admin/Admin.php");
                    } else {
                        header("Location: ../Dashboards/User/User.php");
                    }
                    exit();
                } else {
                    $errors['password'] = "Invalid password";
                }
            } else {
                $errors['email'] = "Email not found";
            }
        } catch (Exception $e) {
            $errors['general'] = "Login failed: " . $e->getMessage();
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    // If there are errors, store them in session and redirect back
    if (array_filter($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: ../Register.php");
        exit();
    }
}
?>