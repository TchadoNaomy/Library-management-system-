<?php
include_once '../../Backend/session_checker.php';
checkSession();
include_once '../../Backend/User/dashboardhandler.php';

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
    <link rel="stylesheet" href="../../Assets/Styles/User.css">
    <link rel="stylesheet" href="../../Assets/Styles/Theme.css">
    <link rel="stylesheet" href="../../Assets/fontawesome/css/all.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="sideBar">
        <div class="profilePic">
            <?php if (isset($_SESSION['profile_image'])): ?>
                <img src="data:image/jpeg;base64,<?php echo $_SESSION['profile_image']; ?>" alt="Profile">
            <?php else: ?>
                <img src="../../Assets/Images/logo.jfif" alt="Default Profile">
            <?php endif; ?>
            <p class="msg" data-translate="welcome"></p>
            <p class="Uname"><?php echo $User; ?></p>
            <p class="role"><?php echo $Role; ?></p>
        </div>
        <nav>
            <ul>
                <li class="active"><a href="../User/User.php"><i class="fas fa-qrcode"></i> <span data-translate="dashboard">Dashboard</span></a></li>
                <li><a href="../../Catalog.php"><i class="fas fa-file-lines" class="icon"></i> <span data-translate="catalog">Catalog</span></a></li>
                <li><a href="Favourite.php"><i class="fas fa-star" class="icon"></i> <span data-translate="favouriteBooks">FavouriteBook</span></a></li>
                <li><a href="./Settings.php"><i class="fas fa-gear" class="icon"></i> <span data-translate="settings">Settings</span></a></li>
                <li><a href="../../Backend/logout.php"><i class="fas fa-sign-out-alt"></i> <span data-translate="logout">LogOut</span></a></li>
            </ul>
        </nav>
        <footer >
        <p class="footer">&copy;2025 Library-Management System Group 2 <br>
                All rights reserved </p>
        </footer>
    </div>
                        <div class="mainContent">
                            <nav>
                                <div class="mobileMenu">
                                    <i class="fas fa-bars fa-2x"></i>
                                </div>
                                <p class="title">
                                    <i class=""></i>
                                    
                                </p>
                                <div class="notificationBox">
                                    <div class="counter">
                                        <p>0</p>
                                    </div>
                                    <i class="fas fa-bell fa-2x"></i>
                                </div>
                            </nav>
                                    <main>
                                       
                                    </main>
                        </div>

 <!-- script to prevent backarrow functionality if user is logged in -->
 <!-- <script src="../../Assets//Scripts/stateMaintaine.js"></script> -->
</body>
<!-- other scripts -->
<script src="../../Assets/Scripts/displayMenu.js"></script>
<script src="../../Assets/Scripts/updateTitle.js"></script>
<script src="../../Assets/Scripts/themeManager.js"></script>
<script src="../../Assets/Scripts/languageManager.js"></script>
</html>