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
    <link rel="stylesheet" href="../../Assets/Styles/manageStock.css">
    <link rel="stylesheet" href="../../Assets/fontawesome/css/all.css">
    <title>manage Stock</title>
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
                <li class="active"><a href="../Admin/manageStock.php"><i class="fas fa-boxes-stacked" class="icon"></i>  Manage Stock </a></li>
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
    <div class="stock-container">
        <!-- Suppliers Section -->
        <div class="section">
            <div class="section-header">
                <h2>Suppliers</h2>
                <button id="add-supplier-btn" class="add-btn">
                    <i class="fas fa-plus"></i> Add Supplier
                </button>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="suppliers-table-body">
                        <?php include '../../Backend/Admin/getSuppliers.php'; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Orders Section -->
        <div class="section">
            <div class="section-header">
                <h2>Purchase Orders</h2>
                <button id="create-order-btn" class="add-btn">
                    <i class="fas fa-plus"></i> Create Order
                </button>
            </div>
            <div class="table-container">
                <table class="table" border="1">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Supplier</th>
                            <th>Order Date</th>
                            <th>Total Items</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="orders-table-body">
                        <?php include '../../Backend/Admin/getOrders.php'; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Supplier Modal -->
    <div id="supplier-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="supplier-modal-title">Add Supplier</h2>
            <form id="supplier-form">
                <input type="hidden" id="supplier-id" name="supplier_id">
                <div class="form-group">
                    <label for="supplier-name">Name</label>
                    <input type="text" id="supplier-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="supplier-email">Email</label>
                    <input type="email" id="supplier-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="supplier-contact">Contact</label>
                    <input type="tel" id="supplier-contact" name="phone_number" required>
                </div>
                <div class="form-group">
                    <label for="supplier-address">Address</label>
                    <textarea id="supplier-address" name="address" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Order Modal -->
    <div id="order-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="order-modal-title">Create Purchase Order</h2>
            <form id="order-form">
                <input type="hidden" name="order_id" id="order-id">
                <div class="form-group">
                    <label for="supplier-select">Supplier:</label>
                    <select id="supplier-select" name="supplier_id" required>
                        <!-- Suppliers will be loaded here -->
                    </select>
                </div>
                <div id="order-items">
                    <!-- Order items will be added here -->
                </div>
                <button type="button" id="add-item-btn" class="secondary-btn">
                    <i class="fas fa-plus"></i> Add Item
                </button>
                <button type="submit" class="submit-btn">Create Order</button>
            </form>
        </div>
    </div>
</main>
                    </div>
</body>

<script src="../../Assets/Scripts/displayMenu.js"></script>
<script src="../../Assets/Scripts/updateTitle.js"></script>
<script src="../../Assets/Scripts/themeManager.js"></script>
<script src="../../Assets/Scripts/stockManager.js"></script>
<!-- script to prevent backarrow functionality if user is logged in -->
<!-- <script src="../../Assets//Scripts/stateMaintaine.js"></script> -->
</html>