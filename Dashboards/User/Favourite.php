<?php
include_once '../../Backend/session_checker.php';
checkSession();
include_once '../../Backend/User/dashboardhandler.php';

// Get user data from session
$User = $_SESSION['user_name'] ?? '';
$Role = $_SESSION['user_role'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Assets/Styles/User.css">
    <link rel="stylesheet" href="../../Assets/Styles/Theme.css">
    <link rel="stylesheet" href="../../Assets/Styles/Catalog.css">
    <link rel="stylesheet" href="../../Assets/fontawesome/css/all.css">
    <style>
        .no-favorites {
            text-align: center;
            padding: 20px;
            font-size: 1.2em;
            color: #666;
            grid-column: 1 / -1;
        }
        
        .error {
            color: #f44336;
            text-align: center;
            padding: 20px;
            grid-column: 1 / -1;
        }

        .mainContent .catalogue {
            padding: 20px;
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            height: calc(100vh - 150px);
            overflow-y: auto;
        }

        .search-bar {
            padding: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .search-bar input {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .mainContent {
            margin-left: 250px;
            padding: 20px;
            background: #f4f4f4;
        }

        @media (max-width: 768px) {
            .mainContent {
                margin-left: 0;
            }
            
            .mainContent .catalogue {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <title>Favourite Books</title>
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
                <li><a href="../User/User.php"><i class="fas fa-qrcode"></i>  Dashboard </a></li>
                <li><a href="../../Catalog.php"><i class="fas fa-file-lines" class="icon"></i> Catalog </a></li>
                <li class="active"><a href="Favourite.php"><i class="fas fa-star" class="icon"></i> Favourite Books </a></li>
                <li><a href="./Settings.php"><i class="fas fa-gear" class="icon"></i>  Settings </a></li>
                <li><a href="../../Backend/logout.php"><i class="fas fa-sign-out-alt"></i>  LogOut </a></li>
            </ul>
        </nav>
        <footer>
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
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search favorite books...">
            </div>

            <div class="catalogue" id="bookCatalogue">
                <?php
                // Database configuration
                $host = 'localhost';
                $username = 'root';
                $password = '';
                $database = 'library_management';

                try {
                    $conn = new mysqli($host, $username, $password, $database);
                    if ($conn->connect_error) {
                        throw new Exception("Connection failed: " . $conn->connect_error);
                    }

                    // Get favorite books for current user
                    $userId = $_SESSION['user_id'];
                    $query = "SELECT b.* FROM books b 
                             INNER JOIN favourite f ON b.book_id = f.book_id 
                             WHERE f.user_id = ? 
                             ORDER BY f.fav_id DESC";
                    
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($book = $result->fetch_assoc()) {
                            ?>
                            <div class="book-card book-container">
                                <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                <?php if (!empty($book['book_cover'])): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($book['book_cover']); ?>" 
                                        alt="Book Cover" class="cover-thumbnail">
                                <?php else: ?>
                                    <img src="../../Assets/Images/default-book.jpg" 
                                        alt="Default Cover" class="cover-thumbnail">
                                <?php endif; ?>
                                <div class="book-title"><?php echo htmlspecialchars($book['title']) ?></div>
                                <div class="book-author"><?php echo htmlspecialchars($book['author']) ?></div>
                                <div class="book-genre"><?php echo htmlspecialchars($book['genre']) ?></div>
                                <div class="book-desc"><?php echo htmlspecialchars($book['description']) ?></div>
                                <div class="availability">
                                    <abbr title="Remove from favorites" class="fav-container">
                                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                        <i class="fas fa-star favorited" id="fav"></i>
                                    </abbr>
                                    <abbr title="Download to read later"><i class="fas fa-download" id="downld"></i></abbr>
                                    <button>Read Now</button>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="no-favorites">No favorite books found</div>';
                    }

                    $stmt->close();
                    $conn->close();

                } catch (Exception $e) {
                    echo '<div class="error">Error loading favorite books: ' . $e->getMessage() . '</div>';
                }
                ?>
            </div>
        </main>
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const bookCards = document.querySelectorAll('.book-card');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            bookCards.forEach(card => {
                const title = card.querySelector('.book-title').textContent.toLowerCase();
                const author = card.querySelector('.book-author').textContent.toLowerCase();
                const desc = card.querySelector('.book-desc').textContent.toLowerCase();

                const match = title.includes(searchTerm) || 
                            author.includes(searchTerm) || 
                            desc.includes(searchTerm);

                card.style.display = match ? 'block' : 'none';
            });
        });
    </script>

    <script src="../../Assets/Scripts/displayMenu.js"></script>
    <script src="../../Assets/Scripts/updateTitle.js"></script>
    <script src="../../Assets/Scripts/themeManager.js"></script>
    <script src="../../Assets/Scripts/FavouriteBook.js"></script>
</body>
</html>