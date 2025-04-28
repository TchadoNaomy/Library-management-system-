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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>library services</title>
    <link rel="stylesheet" href="Assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="./Assets/Styles/aboutus.css">
    <link rel="stylesheet" href="Assets/Styles/index.css">
</head>
<body>
<header>
                <h1><i class="fas fa-book-open"></i> Genesia Libraria </h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="aboutus.php">About</a></li>
                <li><a href="Catalog.php">Catalog</a></li>
                <li><a href="contact.php">Contact</a></li>
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
   <div class="Container">
   <section class="about">
        <div class="images">
            <img src="images\assistance.jpg" alt="">
            <img src="images\borror.jpg" alt="">
            <img src="images\program for adult and children.jpg" alt="">
            <img src="images\program.jpg" alt="">
        </div >
                <div class="text">
                    <h2>We Are A Full Service Library</h2>
                    <p>Our library existed in since 1985 located in 
                        yaounde Cameroon,was one of the largest and most significant libraries 
                        of the ancient world:it has scriptoria where scholars copy and translate text preserving
                        knowledge from ancient civilisation </h1></p>
                    <p><strong>Library remain vibrant hubs of Knowledge,culture, and community engagement.</strong>
                    it has scriptoria where scholars copy and translate text preserving knowledge from ancient civilisation</p>
                </div>

                <h2>What We Do</h2>
     <div class="cards">
        <div class="residential">
            <h3>Borrowing facility</h3>
            <p>Borrow several types of books</p>
            <a href="#" style="text-decoration: overline;
            color:#3498DB;
            ">
            Learn More</a>
        </div>
            <div class="commercial">
            <h3>Assistance Services</h3>
            <p>we provide assistance to our customers</p>
            <a href="#" style="text-decoration: overline;
            color:#3498DB;
            ">
            Learn More</a>
            </div>
            <div class="automotive">
                    <h3> books for all ages</h3>
                    <p>we provide Reading,Workshop,Lectures</p>
                    <a href="#" style="text-decoration: overline; 
                    color:#3498DB;
                    ">
                    Learn More</a>
            </div>
        </div>
   </section>   
   <section class="mapContainer">
   <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3980.9832494136153!2d11.5530201!3d3.8136977!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bdac4e998717f%3A0xe68aa93952495cc3!2sIAI%20Cameroun%20(Centre%20d&#39;Excelence%20Technologique%20Paul%20Biya)!5e0!3m2!1sfr!2scm!4v1745431234635!5m2!1sfr!2scm"
     width="691" 
     height="600" 
     style="border:0;
     border-radius: 10px;" 
     allowfullscreen="" 
     loading="lazy" 
     referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
   
   </div>
</body>
</html>