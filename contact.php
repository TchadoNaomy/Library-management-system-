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
                <li><a href="index.php" data-translate="home">Home</a></li>
                <li><a href="aboutus.php" data-translate="about">About</a></li>
                <li><a href="Catalog.php" data-translate="catalog">Catalog</a></li>
                <li><a class="active" href="contact.php" data-translate="contact">Contact</a></li>
            </ul>
        </nav>
        <div class="buttonContainer">
        <?php if (isset($_SESSION['user_role']) == 'client'): ?>
            <a href="Register.php" style="display: none;"><button class="signupbtn" data-translate="signUp">SignUp</button></a> 
            <?php else: ?>
           <a href="Register.php"><button class="signupbtn" data-translate="signUp">SignUp</button></a> 
            <?php endif; ?>
        </div>
    </header>
    <section class="hero">
        <div class="overlay">
            <h2 data-translate="contactUs">CONTACT US</h2>
            <p data-translate="contactIntro">you can get in touch with us through several ways</p>
        </div>
    </section>
    <section class="contact-options">
        <div class="card">
            <div class="imageC">
                <img src="./Assets/Images/assistance.jpg" alt="image">
            </div>
            <div class="infoC">
                <p data-translate="contactTeamDesc">
                    get in touch with our team available 24/7      
                </p>
            </div>
            <button class="button">
            <i class="fas fa-message"></i>
            <span data-translate="contactTeam">Contact Team</span>
            </button>
        </div>
        <div class="card">
            <div class="imageC">
                <img src="./Assets/Images/assistance.jpg" alt="image">
            </div>
            <div class="infoC">
                <p data-translate="expertAdviceDesc">
                    get advices from our experts in the domain      
                </p>
            </div>
            <button class="button">
            <i class="fas fa-phone"></i>
            <span data-translate="callUs">Call Us</span>
            </button>
        </div>
        <div class="card">
            <div class="imageC">
                <img src="./Assets/Images/assistance.jpg" alt="image">
            </div>
            <div class="infoC">
                <p data-translate="feedbackDesc">
                    give us your opinion/observations       
                </p>
            </div>
            <button class="button">
            <i class="fas fa-envelope"></i>
            <span data-translate="mailUs">Mail Us</span>
            </button>
        </div>
    </section>
    <script src="./Assets/Scripts/languageManager.js"></script>
</body>
</html>