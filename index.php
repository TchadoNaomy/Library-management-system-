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
            <section>
                <h2>About Us</h2>
                <p>This is a simple home page template for demonstration purposes.</p>
            </section>
            <section>
                <h2>Services</h2>
                <?php
                echo $Role;
                ?>
                <p>We offer a range of services to meet your needs.</p>
            </section>
        </main>
            <footer>
                <p>&copy; 2025 My Website</p>
            </footer>
</body>
</html>