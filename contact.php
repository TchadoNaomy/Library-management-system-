<?php
require_once './Backend/login_handler.php';
// checkSession();
include_once './Backend/User/dashboardhandler.php';

// Get user data from session
$User = $_SESSION['user_name'] ?? '';
$Role = $_SESSION['user_role'] ?? '';

// Debugging code - remove in production
// var_dump($_SESSION);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact us</title>
    <link rel="stylesheet" href="./Assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="./Assets/Styles/index.css">
    <link rel="stylesheet" href="./Assets/Styles/contact.css">
</head>
<body>
<header>
            <h1><i class="fas fa-book-open"></i> Genesia Libraria </h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="aboutus.php">About</a></li>
                <li><a href="Catalog.php">Catalog</a></li>
                <li><a  class="active" href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <div class="buttonContainer">
        <?php if (isset($_SESSION['user_role']) == 'client'): ?>
            <a href="Register.php" style="display: none;"><button class="signupbtn" >SignUp</button></a> 
            <?php else: ?>
           <a href="Register.php"><button class="signupbtn" >SignUp</button></a> 
            <?php endif; ?>
        </div>
    </header>
    <section class="hero">
        <div class="overlay">
            <h2>CONTACT US</h2>
            <p>you can get in touch with us through several ways</p>
        </div>
    </section>
    <section class="contact-options">
        <div class="card">
            <div class="imageC">
                <img src="./Assets/Images/assistance.jpg" alt="image">
            </div>
            <div class="infoC">
                <p>
                    get in touch with our team  available 24/7      
                </p>
            </div>
            <button class="button">
            <i class="fas fa-message"></i>
            Contact Team
            </button>
        </div>
        <div class="card">
            <div class="imageC">
                <img src="./Assets/Images/assistance.jpg" alt="image">
            </div>
            <div class="infoC">
                <p>
                    get advices from our experts in the domain      
                </p>
            </div>
            <button class="button">
            <i class="fas fa-phone"></i>
            Call Us
            </button>
        </div>
        <div class="card">
            <div class="imageC">
                <img src="./Assets/Images/assistance.jpg" alt="image">
            </div>
            <div class="infoC">
                <p>
                    give us your opinion/observations       
                </p>
            </div>
            <button class="button">
            <i class="fas fa-envelope"></i>
           Mail Us
            </button>
        </div>
    </section>
</body>
</html>