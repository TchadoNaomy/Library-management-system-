<?php
include_once '../../Backend/session_checker.php';
checkSession();
include_once '../../Backend/Admin/dashboardhandler.php';
include_once '../../Backend/Admin/fetchUsers.php';
$users = fetchUsers();

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
    <link rel="stylesheet" href="../../Assets/Styles/Acount.css">
    <link rel="stylesheet" href="../../Assets/Styles/Theme.css">
    <link rel="stylesheet" href="../../Assets/fontawesome/css/all.css">
    <title>Manage Accounts</title>
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
                <li class="active"><a href="../Admin/Acount.php"><i class="fas fa-users-gear" class="icon"></i>  Manage Acounts </a></li>
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
                                    <div class="search">
                                            <input type="text" id="account-search-input" 
                                            placeholder="Search a user..." maxlength="100">
                                                <abbr title="Search Users">
                                                    <button class="search-btn" id="account-search-btn">
                                                        <i class="fas fa-magnifying-glass"></i>
                                                    </button>
                                                </abbr>
                                    </div>
                                    <div class="tabContainer">
                                        <table class="table" border="1">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th class="mobile-hide">Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th class="mobile-hide">Avatar</th>
                                                    <th class="mobile-hide">Creation Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($users as $user): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                                        <td class="mobile-hide"><?php echo htmlspecialchars($user['name']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                                                        <td class="mobile-hide">
                                                            <?php if ($user['profile_image']): ?>
                                                                <img src="data:image/jpeg;base64,<?php echo $user['profile_image']; ?>" 
                                                                     alt="Profile" class="profile-thumbnail">
                                                                     <?php else: ?>
                                                                <img src="../../Assets/Images/logo.jfif" 
                                                                     alt="Default Profile" class="profile-thumbnail">
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="mobile-hide"><?php echo date('Y-m-d', strtotime($user['created_at'])); ?></td>
                                                        <td>
                                                            <abbr title="Edit User">
                                                                <button class="edit-btn" data-id="<?php echo $user['user_id']; ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            </abbr>
                                                            
                                                            <?php if ($user['role'] !== 'suspended'): ?>
                                                                <abbr title="Suspend User">
                                                                    <button class="suspend-btn" data-id="<?php echo $user['user_id']; ?>">
                                                                        <i class="fas fa-ban"></i>
                                                                    </button>
                                                                </abbr>
                                                            <?php else: ?>
                                                                <abbr title="Restore User">
                                                                    <button class="unsuspend-btn" data-id="<?php echo $user['user_id']; ?>">
                                                                        <i class="fas fa-user-check"></i>
                                                                    </button>
                                                                </abbr>
                                                            <?php endif; ?>
                                                            
                                                            <abbr title="Delete User">
                                                                <button class="delete-btn" data-id="<?php echo $user['user_id']; ?>">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </abbr>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    </main>
                    </div>


                                <div class="popup" id="popup">
                                    <div class="popup-content">
                                        <span class="close-btn">&times;</span>
                                        <h2>Delete User</h2>
                                        <p>Are you sure you want to delete this user?</p>
                                        <button id="confirm-delete-btn">Delete</button>
                                        <button id="cancel-delete-btn">Cancel</button>
                                    </div>
                                </div>

                                <div class="popup" id="edit-popup">
                                    <div class="popup-content">
                                        <span class="close-btn">&times;</span>
                                        <h2>Edit User</h2>
                                        <form id="edit-user-form">
                                            <input type="hidden" name="user_id" id="edit-user-id">
                                            <label for="edit-role">Role:</label>
                                            <select name="role" id="edit-role">
                                                <option value="admin">Admin</option>
                                                <option value="client">Client</option>
                                            </select>
                                            <button type="submit">Save Changes</button>
                                        </form>
                                    </div>
                                </div>


<script src="../../Assets/Scripts/displayMenu.js"></script>
<script src="../../Assets/Scripts/updateTitle.js"></script>
<script src="../../Assets/Scripts/themeManager.js"></script>
<script src="../../Assets/Scripts/accountSearch.js"></script>
<script src="../../Assets/Scripts/userManager.js"></script>
<!-- script to prevent backarrow functionality if user is logged in -->
<!-- <script src="../../Assets//Scripts/stateMaintaine.js"></script> -->
</body>
</html>