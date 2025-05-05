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
    <link rel="stylesheet" href="../../Assets/Styles/Report.css">
    <link rel="stylesheet" href="../../Assets/Styles/Theme.css">
    <link rel="stylesheet" href="../../Assets/fontawesome/css/all.css">
    <title>APP statistics</title>
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
            <p class="Uname"><?php echo $User?></p>
            <p class="role"><?php echo $Role?></p>
        </div>
        <nav>
            <ul>
                <li><a href="../Admin/Admin.php"><i class="fas fa-qrcode"></i> <span data-translate="dashboard"></span></a></li>
                <li><a href="../Admin/Acount.php"><i class="fas fa-users-gear" class="icon"></i> <span data-translate="manageAccounts"></span></a></li>
                <li><a href="../Admin/Book.php"><i class="fas fa-book" class="icon"></i> <span data-translate="manageBooks"></span></a></li>
                <li><a href="../Admin/manageStock.php"><i class="fas fa-boxes-stacked" class="icon"></i> <span data-translate="manageStock"></span></a></li>
                <li class="active"><a href="../Admin/Reports.php"><i class="fas fa-chart-bar" class="icon"></i> <span data-translate="reports"></span></a></li>
                <li><a href="../Admin/Settings.php"><i class="fas fa-gear" class="icon"></i> <span data-translate="settings"></span></a></li>
                <li><a href="../../Backend/logout.php"><i class="fas fa-sign-out-alt"></i> <span data-translate="logout"></span></a></li>
            </ul>
        </nav>
        <footer>
            <p class="footer">&copy;2025 Library-Management System Group 2 <br>
                All rights reserved</p>
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
                                    <div class="stats-summary">
                                        <div class="stat-card">
                                            <i class="fas fa-users fa-2x"></i>
                                            <h3 data-translate="totalUsers">Total Users</h3>
                                            <p class="count"><?php echo $userCount?></p>
                                        </div>
                                        <div class="stat-card">
                                            <i class="fas fa-book fa-2x"></i>
                                            <h3 data-translate="totalBooks">Total Books</h3>
                                            <p class="count"><?php echo $bookCount ?> </p>
                                        </div>
                                        <div class="stat-card">
                                            <i class="fas fa-book-open fa-2x"></i>
                                            <h3 data-translate="booksBorrowed">Books Borrowed</h3>
                                            <p class="count"><?php echo $borrowCount?></p>
                                        </div>
                                    </div>
                                            <div class="date-range">
                                                <label for="start-date" data-translate="from">From:</label>
                                                <input type="date" id="start-date" name="start-date" 
                                                       value="<?php echo date('Y-m-01'); ?>" 
                                                       max="<?php echo date('Y-m-d'); ?>">
                                                <label for="end-date" data-translate="to">To:</label>
                                                <input type="date" id="end-date" name="end-date" 
                                                       value="<?php echo date('Y-m-d'); ?>" 
                                                       max="<?php echo date('Y-m-d'); ?>">
                                                <button class="filter-btn" id="filterData">
                                                    <i class="fas fa-filter"></i> <span data-translate="filter">Filter</span>
                                                </button>
                                            </div>
                                                    <div class="chart-container">
                                                        <canvas id="libraryChart"></canvas>
                                                    </div>
                                </main>
                    </div>

                       
</body>
<!-- scripts for handling dynamic title updates and mobile 
 side bar menu display button -->
<script src="../../Assets/Scripts/displayMenu.js"></script>
<script src="../../Assets/Scripts/updateTitle.js"></script>
<script src="../../Assets/Scripts/themeManager.js"></script>

<!-- script to prevent backarrow functionality if user is logged in -->
<!-- <script src="../../Assets//Scripts/stateMaintaine.js"></script> -->

<!-- scripts for handling charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../../Assets/Scripts/libraryChart.js"></script>   

<!-- Add languageManager.js script reference -->
<script src="../../Assets/Scripts/languageManager.js"></script>
</body>
</html>