<?php
include_once '../../Backend/session_checker.php';
checkSession();
include_once '../../Backend/Admin/dashboardhandler.php';
include_once '../../Backend/Admin/fetchBooks.php';

// Get user data from session
$User = $_SESSION['user_name'] ?? '';
$Role = $_SESSION['user_role'] ?? '';

// Fetch books
$books = getBooks();
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
    <title>Manage Books</title>
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
                <li ><a href="../Admin/Acount.php"><i class="fas fa-users-gear" class="icon"></i>  Manage Acounts </a></li>
                <li class="active"><a href="../Admin/Book.php"><i class="fas fa-book" class="icon"></i>  Manage Books </a></li>
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
                                        <input type="text" id="book-search-input" maxlength="100" 
                                        placeholder="Search a book...">

                                            <button class="search-btn" id="book-search-btn">
                                                <i class="fas fa-magnifying-glass"></i>
                                            </button>
                                </div>
                                <div class="tabContainer">
                                    <table class="table" border="1">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th class="mobile-hide">Cover</th>
                                                <th>Title</th>
                                                <th class="mobile-hide">Author</th>
                                                <th class="mobile-hide">Publisher</th>
                                                <th class="mobile-hide">Publication Date</th>
                                                <th class="mobile-hide">ISBN</th>
                                                <th class="mobile-hide">Quantity</th>
                                                <th class="mobile-hide">Arrival Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($books && count($books) > 0): ?>
                                                <?php foreach ($books as $book): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($book['book_id']); ?></td>
                                                        <td class="book-cover mobile-hide">
                                                            <?php if (!empty($book['book_cover'])): ?>
                                                                <img src="data:image/jpeg;base64,<?php echo $book['book_cover']; ?>" 
                                                                     alt="Book Cover" class="cover-thumbnail">
                                                            <?php else: ?>
                                                                <img src="../../Assets/Images/default-book.jpg" 
                                                                     alt="Default Cover" class="cover-thumbnail">
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                                                        <td class="mobile-hide"><?php echo htmlspecialchars($book['author']); ?></td>
                                                        <td class="mobile-hide"><?php echo htmlspecialchars($book['publisher']); ?></td>
                                                        <td class="mobile-hide"><?php echo date('Y-m-d', strtotime($book['publication_date'])); ?></td>
                                                        <td class="mobile-hide"><?php echo htmlspecialchars($book['ISBN']); ?></td>
                                                        <td class="mobile-hide"><?php echo htmlspecialchars($book['quantity']); ?></td>
                                                        <td class="mobile-hide"><?php echo date('Y-m-d', strtotime($book['added_date'])); ?></td>
                                                        <td>
                                                            <abbr title="Edit Book">
                                                                <button class="edit-btn" data-id="<?php echo $book['book_id']; ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            </abbr>
                                                            <abbr title="Delete Book">
                                                                <button class="delete-btn" data-id="<?php echo $book['book_id']; ?>">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </abbr>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="10" class="no-data">No books found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="addBookBtn">
                                    <button id="add-book-btn">Add Book</button>
                                </div>
                                <div class="modal" id="book-modal">
                                    <div class="modal-content">
                                        <span class="close-btn">&times;</span>
                                        <h2 id="modal-title">Add Book</h2>
                                        <form id="book-form" enctype="multipart/form-data">
                                            <input type="hidden" name="book_id" id="book-id">
                                            
                                            <div class="form-group">
                                                <label for="title">Title:</label>
                                                <input type="text" name="title" id="title" required maxlength="100">
                                            </div>

                                            <div class="form-group">
                                                <label for="author">Author:</label>
                                                <input type="text" name="author" id="author" required maxlength="100">
                                            </div>

                                            <div class="form-group">
                                                <label for="publisher">Publisher:</label>
                                                <input type="text" name="publisher" id="publisher" required maxlength="100">
                                            </div>

                                            <div class="form-group">
                                                <label for="publication_date">Publication Date:</label>
                                                <input type="date" name="publication_date" id="publication_date" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="ISBN">ISBN:</label>
                                                <input type="text" name="ISBN" id="ISBN" required maxlength="20">
                                            </div>

                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" name="quantity" id="quantity" required min="1">
                                            </div>

                                            <div class="form-group">
                                                <label for="book_cover">Book Cover:</label>
                                                <input type="file" name="book_cover" id="book_cover" accept="image/*">
                                            </div>

                                            <button type="submit">Save Book</button>
                                        </form>
                                    </div>
                                </div>
                                </main>
                    </div>


<script src="../../Assets/Scripts/displayMenu.js"></script>
<script src="../../Assets/Scripts/updateTitle.js"></script>
<script src="../../Assets/Scripts/themeManager.js"></script>
<script src="../../Assets/Scripts/bookSearch.js"></script>
<script src="../../Assets/Scripts/bookManager.js"></script>
<!-- script to prevent backarrow functionality if user is logged in -->
<!-- <script src="../../Assets//Scripts/stateMaintaine.js"></script> -->
</body>
</html>