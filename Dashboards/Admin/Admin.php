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
            <img src="../../Assets/Images/logo.jfif" alt="Logo">
            <p class="msg"> Welcome </p>
            <p class="Uname"> Username </p>
            <p class="role"> Admin </p>
        </div>
        <nav>
            <ul>
                <li class="active"><a href="../Admin/Admin.php"><i class="fas fa-qrcode" ></i>  Dashboard </a></li>
                <li><a href="../Admin/Acount.php"><i class="fas fa-users-gear" class="icon"></i>  Manage Acounts </a></li>
                <li><a href="../Admin/Book.php"><i class="fas fa-book" class="icon"></i>  Manage Books </a></li>
                <li><a href="../Admin/manageStock.php"><i class="fas fa-boxes-stacked" class="icon"></i>  Manage Stock </a></li>
                <li><a href="../Admin/Reports.php"><i class="fas fa-chart-bar" class="icon"></i>  Reports </a></li>
                <li><a href="../Admin/Settings.php"><i class="fas fa-gear" class="icon"></i>  Settings </a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt" ></i>  LogOut </a></li>
              
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
                                                <p class="count"><?php echo "80" ?></p>
                                            </div>
                                            <div class="card">
                                                <i class="fas fa-book fa-3x"></i>
                                                <h3>Total Books</h3>
                                                <p class="count"><?php echo "400" ?></p>
                                            </div>
                                            <div class="card">
                                                <i class="fas fa-book-open fa-3x"></i>
                                                <h3>Books Borrowed</h3>
                                                <p class="count"><?php echo "200" ?></p>
                                            </div>
                                            <div class="card">
                                                <i class="fas fa-clock fa-3x"></i>
                                                <h3>Pending Returns</h3>
                                                <p class="count"><?php echo "0" ?></p>
                                            </div>
                                        </div>
                                    </main>
                        </div>
</body>
<!-- other scripts -->
<script src="../../Assets/Scripts/displayMenu.js"></script>
<script src="../../Assets/Scripts/updateTitle.js"></script>
<script src="../../Assets/Scripts/libraryChart.js"></script>
<script src="../../Assets/Scripts/themeManager.js"></script>
<!-- Script for storing cards data to local storage on page load -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const countElements = document.querySelectorAll('.count');
    const libraryData = Array.from(countElements).map(element => parseInt(element.textContent));
    localStorage.setItem('libraryStats', JSON.stringify(libraryData));
});
</script>

</html>