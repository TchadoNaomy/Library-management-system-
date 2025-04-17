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
    <link rel="stylesheet" href="../../Assets/Styles/Settings.css">
    <link rel="stylesheet" href="../../Assets/Styles/Theme.css">
    <link rel="stylesheet" href="../../Assets/fontawesome/css/all.css">
    <title>Settings</title>
</head>
<body>
    <div class="sideBar">
        <div class="profilePic">
        <?php if (isset($_SESSION['profile_image'])): ?>
                <img src="data:image/jpeg;base64,<?php echo $_SESSION['profile_image']; ?>" alt="Profile">
            <?php else: ?>
                <img src="../../Assets/Images/logo.jfif" alt="Default Profile">
            <?php endif; ?>
            <p class="msg"> Welcome </p>
            <p class="Uname"> <?php echo $User?> </p>
            <p class="role"> <?php echo $Role?> </p>
        </div>
        <nav>
            <ul>
                <li ><a href="../Admin/Admin.php"><i class="fas fa-qrcode" ></i>  Dashboard </a></li>
                <li><a href="../Admin/Acount.php"><i class="fas fa-users-gear" class="icon"></i>  Manage Acounts </a></li>
                <li><a href="../Admin/Book.php"><i class="fas fa-book" class="icon"></i>  Manage Books </a></li>
                <li><a href="../Admin/manageStock.php"><i class="fas fa-boxes-stacked" class="icon"></i>  Manage Stock </a></li>
                <li><a href="../Admin/Reports.php"><i class="fas fa-chart-bar" class="icon"></i>  Reports </a></li>
                <li class="active"><a href="../Admin/Settings.php"><i class="fas fa-gear" class="icon"></i>  Settings </a></li>
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
                        </nav>
                                <main>
                                    <div class="settings-container">
                                        <!-- Language Settings Card -->
                                        <div class="settings-card">
                                            <div class="card-header">
                                                <i class="fas fa-language fa-2x"></i>
                                                <h3>Language Settings</h3>
                                            </div>
                                            <div class="card-content">
                                                <select id="languageSelect" class="settings-select">
                                                    <option value="en">English</option>
                                                    <option value="fr">French</option>
                                                    <option value="es">Spanish</option>
                                                </select>
                                            </div>
                                        </div>

                                            <!-- Theme Settings Card -->
                                            <div class="settings-card">
                                                <div class="card-header">
                                                    <i class="fas fa-palette fa-2x"></i>
                                                    <h3>Theme Settings</h3>
                                                </div>
                                                <div class="card-content">
                                                    <div class="theme-options">
                                                        <label class="theme-option">
                                                            <input type="radio" name="theme" value="default" checked>
                                                            <span>Default</span><i class="fas fa-circle-half-stroke"></i>
                                                        </label>
                                                        <label class="theme-option">
                                                            <input type="radio" name="theme" value="light">
                                                            <span>Light Mode</span><i class="fas fa-sun"></i>
                                                        </label>
                                                        <label class="theme-option">
                                                            <input type="radio" name="theme" value="dark">
                                                            <span>Dark Mode</span><i class="fas fa-moon"></i>
                                                        </label>
                                                        <label class="theme-option">
                                                            <input type="radio" name="theme" value="booksphere">
                                                            <span>Book Sphere</span><i class="fas fa-book-open-reader"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                                    <!-- Notification Settings Card -->
                                                    <div class="settings-card">
                                                        <div class="card-header">
                                                            <i class="fas fa-bell fa-2x"></i>
                                                            <h3>Notification Settings</h3>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="notification-options">
                                                                <label class="switch">
                                                                    <input type="checkbox" checked>
                                                                    <span class="slider">Email Notifications</span>
                                                                </label>
                                                                <label class="switch">
                                                                    <input type="checkbox" checked>
                                                                    <span class="slider">System Notifications</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Profile picture Settings Card -->
                                                    <div class="settings-card">
                                                        <div class="card-header">
                                                            <i class="fas fa-image fa-2x"></i>
                                                            <h3>Profile Picture Settings</h3>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="notification-options">
                                                                <label class="switch">
                                                                    <span class="slider">Change profile picture</span>
                                                                    <button >update Profile Picture</button>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                    </div>
                                </main>
                    </div>
</body>

<script src="../../Assets/Scripts/displayMenu.js"></script>
<script src="../../Assets/Scripts/updateTitle.js"></script>
<script src="../../Assets/Scripts/themeManager.js"></script>

<!-- script to prevent backarrow functionality if user is logged in -->
<!-- <script src="../../Assets//Scripts/stateMaintaine.js"></script> -->

</html>