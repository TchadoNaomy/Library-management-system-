<?php
include_once 'connection.php';

// Initialize error messages array
$errors = array(
    'name' => '',
    'email' => '',
    'password' => '',
    'cpassword' => ''
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $errors['name'] = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
        $errors['name'] = "Only letters and whitespace allowed";
    } else {
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    } else {
        $email = trim($_POST["email"]); // Remove whitespace
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        } else {
            // Only sanitize if email format is valid
            $email = mysqli_real_escape_string($conn, $email);
            
            // Check if email already exists before proceeding
            $checkEmail = $conn->prepare("SELECT user_id FROM user WHERE email = ?");
            if ($checkEmail) {
                $checkEmail->bind_param("s", $email);
                $checkEmail->execute();
                $result = $checkEmail->get_result();
                
                if ($result->num_rows > 0) {
                    $errors['email'] = "Email already exists";
                }
                $checkEmail->close();
            }
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $errors['password'] = "Password is required";
    } elseif (empty($_POST["cpassword"])) {
        $errors['cpassword'] = "Confirm password is required";
    } elseif ($_POST["password"] !== $_POST["cpassword"]) {
        $errors['password'] = "Passwords do not match"; // Changed from alert to error message
    } else {
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    }

    // Check if there are any errors
    $hasErrors = false;
    foreach ($errors as $error) {
        if (!empty($error)) {
            $hasErrors = true;
            break;
        }
    }

    if ($hasErrors) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST; // Save form data
        header("Location: ../Register.php");
        exit();
    }

    try {

        // Insert new user
        $insert = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $name, $email, $password);

        if ($insert->execute()) {
            $_SESSION['success'] = "Registration successful!";
            header("Location: ../index.php");
            exit();
        } else {
            throw new Exception("Registration failed");
        }

    } catch (Exception $e) {
        $_SESSION['errors']['general'] = $e->getMessage();
        $_SESSION['form_data'] = $_POST; // Save form data
        header("Location: ../Register.php");
        exit();
    }
}
?>