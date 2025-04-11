<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Assets/Styles/Admin.css">
    <link rel="stylesheet" href="../../Assets/fontawesome/css/all.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="sideBar">
        <div class="profilePic">
            <img src="../../Assets/Images/logo.jfif" alt="Logo">
            <p class="msg"> Welcome </p>
            <p class="Uname"> Username </p>
            <p class="role"> Admin </p>
        </div>
        <nav>
            <ul>
                <li><a href="../Admin/Admin.php"><i class="fas fa-qrcode" ></i>  Dashboard </a></li>
                <li><a href="../Admin/Users.php"><i class="fas fa-users-gear" ></i>  Manage Acounts </a></li>
                <li><a href="../Admin/Reports.php"><i class="fas fa-boxes-stacked" ></i>  Manage Stock </a></li>
                <li><a href="../Admin/Reports.php"><i class="fas fa-chart-bar" ></i>  Reports </a></li>
                <li><a href="../Admin/Settings.php"><i class="fas fa-gear" ></i>  Settings </a></li>
                <li><a href="../Admin/Reports.php"><i class="fas fa-sign-out-alt" ></i>  LogOut </a></li>
              
            </ul>
        </nav>
        <footer>
            <p>&copy;2025 Library-Management All rights reserved</p>
            <br>
            <p>Designed by: Group 2</p>
        </footer>
    </div>
    <div class="mainContent">
        <nav>
            <div class="mobileMenu">
                <i class="fas fa-bars fa-2x"></i>
            </div>
            <p>
                Dashboard
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
                    <p class="count">0</p>
                </div>
                <div class="card">
                    <i class="fas fa-book fa-3x"></i>
                    <h3>Total Books</h3>
                    <p class="count">0</p>
                </div>
                <div class="card">
                    <i class="fas fa-book-open fa-3x"></i>
                    <h3>Books Borrowed</h3>
                    <p class="count">0</p>
                </div>
                <div class="card">
                    <i class="fas fa-clock fa-3x"></i>
                    <h3>Pending Returns</h3>
                    <p class="count">0</p>
                </div>
            </div>
        </main>
    </div>
</body>

<script src="../../Assets/Scripts/admin.js"></script>

</html>