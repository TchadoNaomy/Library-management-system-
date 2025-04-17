<?php
include_once '../../Backend/session_checker.php';
checkSession();
include_once '../../Backend/Admin/dashboardhandler.php';

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
    <link rel="stylesheet" href="../../Assets/Styles/Admin.css">
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
            <p class="msg">Welcome</p>
            <p class="Uname"><?php echo $User; ?></p>
            <p class="role"><?php echo $Role; ?></p>
        </div>
        <nav>
            <ul>
                <li class="active"><a href="../Admin/Admin.php"><i class="fas fa-qrcode" ></i>  Dashboard </a></li>
                <li><a href="../Admin/Acount.php"><i class="fas fa-users-gear" class="icon"></i>  Manage Acounts </a></li>
                <li><a href="../Admin/Book.php"><i class="fas fa-book" class="icon"></i>  Manage Books </a></li>
                <li><a href="../Admin/manageStock.php"><i class="fas fa-boxes-stacked" class="icon"></i>  Manage Stock </a></li>
                <li><a href="../Admin/Reports.php"><i class="fas fa-chart-bar" class="icon"></i>  Reports </a></li>
                <li><a href="../Admin/Settings.php"><i class="fas fa-gear" class="icon"></i>  Settings </a></li>
                <li><a href="../../Backend/logout.php"><i class="fas fa-sign-out-alt"></i>  LogOut </a></li>
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
                                        <div class="card-container">
                                            <div class="card">
                                                <i class="fas fa-users fa-3x"></i>
                                                <h3>Total Users</h3>
                                                <p class="count"><?php echo $userCount?></p>
                                            </div>
                                            <div class="card">
                                                <i class="fas fa-book fa-3x"></i>
                                                <h3>Total Books</h3>
                                                <p class="count"><?php echo $bookCount?></p>
                                            </div>
                                            <div class="card">
                                                <i class="fas fa-book-open fa-3x"></i>
                                                <h3>Books Borrowed</h3>
                                                <p class="count"><?php echo $borrowCount?></p>
                                            </div>
                                            <div class="card">
                                                <i class="fas fa-clock fa-3x"></i>
                                                <h3>Pending Returns</h3>
                                                <p class="count"><?php echo $pendingCount ?></p>
                                            </div>
                                        </div>
                                    </main>
                        </div>

 <!-- script to prevent backarrow functionality if user is logged in -->
 <!-- <script src="../../Assets//Scripts/stateMaintaine.js"></script> -->
</body>
<!-- other scripts -->
<script src="../../Assets/Scripts/displayMenu.js"></script>
<script src="../../Assets/Scripts/updateTitle.js"></script>
<script src="../../Assets/Scripts/themeManager.js"></script>

</html>