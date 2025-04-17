<?php
session_start();
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : array();
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : array();

// Clear the session data
unset($_SESSION['form_data']);
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Assets/Styles/Register.css">
    <link rel="stylesheet" href="./Assets/fontawesome/css/all.css">
    <title>Register/Login</title>
</head>
<body>
    <div class="signUp">
        <?php if(isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <form action="Backend/signup_handler.php" method="POST" class="signUpform">
            <h1>Sign Up</h1>
            <div class="inputContainer">
                <label for="username">Username:
                    <input type="text" id="username" name="name" required 
                           placeholder="Enter your username"
                           value="<?php echo isset($formData['name']) ? htmlspecialchars($formData['name']) : ''; ?>">
                </label>
                <i class="fas fa-user"></i>
                <?php if(isset($errors['name'])): ?>
                    <span class="error-message"><?php echo $errors['name']; ?></span>
                <?php endif; ?>
            </div>
            <div class="inputContainer">
                <label for="email">Email: 
                    <input type="email" id="email" name="email" required 
                           placeholder="Enter your email"
                           value="<?php echo isset($formData['email']) ? htmlspecialchars($formData['email']) : ''; ?>">
                </label>
                <i class="fas fa-envelope"></i>
                <?php if(isset($errors['email'])): ?>
                    <span class="error-message"><?php echo $errors['email']; ?></span>
                <?php endif; ?>
            </div>
            <div class="inputContainer">
                <label for="password">Password:
                    <input type="password" id="password" name="password" required 
                           placeholder="Enter your password" 
                           value="<?php echo isset($formData['password']) ? htmlspecialchars($formData['password']) : ''; ?>">
                </label>
                <i class="fas fa-lock"></i>
                <?php if(isset($errors['password'])): ?>
                    <span class="error-message"><?php echo $errors['password']; ?></span>
                <?php endif; ?>
            </div>
            <div class="inputContainer">
                <label for="confirmpassword">Confirm Password:
                    <input type="password" id="cpassword" name="cpassword" required 
                           placeholder="Confirm your password" 
                           value="<?php echo isset($formData['cpassword']) ? htmlspecialchars($formData['cpassword']) : ''; ?>">
                </label>
                <i class="fas fa-lock"></i>
                <?php if(isset($errors['cpassword'])): ?>
                    <span class="error-message"><?php echo $errors['cpassword']; ?></span>
                <?php endif; ?>
            </div>
            <button type="submit" class="signupbtn">Sign Up</button>
        </form>


        

        <!-- Login form -->
        <form action="Backend/login_handler.php" method="POST" class="loginform">
            <h1>Login</h1>
            <?php if(isset($errors['general'])): ?>
                <div class="error-message general">
                    <?php echo $errors['general']; ?>
                </div>
            <?php endif; ?>
            
            <div class="inputContainer">
                <label for="email">Email: 
                    <input type="email" id="login_email" name="logemail" required 
                           placeholder="Enter your email"
                           value="<?php echo isset($formData['logemail']) ? htmlspecialchars($formData['logemail']) : ''; ?>">
                </label>
                <i class="fas fa-envelope"></i>
                <?php if(isset($errors['email'])): ?>
                    <span class="error-message"><?php echo $errors['email']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="inputContainer">
                <label for="password">Password:
                    <input type="password" id="login_password" name="logpassword" required 
                           placeholder="Enter your password">
                </label>
                <i class="fas fa-lock"></i>
                <?php if(isset($errors['password'])): ?>
                    <span class="error-message"><?php echo $errors['password']; ?></span>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="loginbtn">Login</button>
        </form>

        <div class="Link">
            <p>Already have an account?<button class="togglebtn">Login</button></p>
        </div>
    </div>

    <script src="./Assets/Scripts/passwordToggle.js"></script>
    <script src="./Assets/Scripts/formToggle.js"></script>

</body>
</html>