<?php
require_once './Backend/login_handler.php';
// checkSession();
include_once './Backend/Admin/dashboardhandler.php';
// session_start();
// Get user data from session
$User = $_SESSION['user_name'] ?? '';
$Role = $_SESSION['user_role'] ?? '';

// var_dump($_SESSION['user_role']);
// Debugging code - remove in production


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="./Assets/Styles/index.css">
    <title>Home</title>
</head>
<body>
<header>
                <h1><i class="fas fa-book-open"></i> Genesia Libraria </h1>
        <nav>
            <ul>
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="aboutus.php">About</a></li>
                <li><a href="Catalog.php">Catalog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <div class="buttonContainer">
            <?php if (isset($_SESSION['user_role']) == 'client'): ?>
            <a href="./Dashboards/User/User.php"><button class="dashBoard">Dashboard</button></a>
            <?php else: ?>
           <a href="Register.php"><button class="signupbtn" >SignUp</button></a> 
            <?php endif; ?>
        </div>
    </header>
        <main>
            <section class="hero">
                <h2>Welcome to Genesia Libraria</h2>
                <p>Your one-stop solution for all your library needs.</p>
                <a href="Catalog.php" class="btn">Explore Now</a>
            </section>

            <section class="features">
                <h2>Features</h2>
                <div class="feature-item">
                    <i class="fas fa-book"></i>
                    <h3>Wide Selection of Books</h3>
                    <p>Explore our extensive collection of books across various genres.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-user"></i>
                    <h3>User-Friendly Interface</h3>
                    <p>Navigate through our platform with ease and find what you need quickly.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-headset"></i>
                    <h3>24/7 Customer Support</h3>
                    <p>Our support team is here to assist you anytime, anywhere.</p>
                </div>
            </section>
        </main>
            <footer style="text-transform: capitalize;">
                <p>&copy; 2025 library management system group 2 all right reserved</p>
            </footer>
</body>
</html>