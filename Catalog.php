<?php
require_once './Backend/login_handler.php';
// checkSession();
include_once './Backend/User/dashboardhandler.php';
include_once './Backend/Admin/fetchBooks.php';

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'library_management';

// Create connection for favorite status checking
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$info = getBooks(); // Fetch books from the database  
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
  <meta name="description" content="Genesia Libraria - Your online library for books and resources.">
  <meta name="keywords" content="books, library, online library, Genesia Libraria">
  <title>Catalogue</title>
  <link rel="stylesheet" href="Assets/fontawesome/css/all.css">
  <link rel="stylesheet" href="Assets/Styles/Catalog.css">
  <link rel="stylesheet" href="Assets/Styles/index.css">
</head>
<header>
            <h1><i class="fas fa-book-open"></i> Genesia Libraria </h1>
        <nav>
            <ul>
                <li><a href="index.php" data-translate="home">Home</a></li>
                <li><a href="aboutus.php" data-translate="about">About</a></li>
                <li><a class="active" href="Catalog.php" data-translate="catalog">Catalog</a></li>
                <li><a href="contact.php" data-translate="contact">Contact</a></li>
            </ul>
        </nav>
        <div class="buttonContainer">
            <?php if (isset($_SESSION['user_role']) == 'client'): ?>
            <a href="./Dashboards/User/User.php"><button class="dashBoard" data-translate="dashboard">Dashboard</button></a>
            <?php else: ?>
           <a href="Register.php"><button class="signupbtn" data-translate="signUp">SignUp</button></a> 
            <?php endif; ?>
        </div>
    </header>
        <main>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for books..." data-translate="search">
            </div>

            <div class="catalogue" id="bookCatalogue">
                <?php foreach ($info as $book): ?>
                <?php
                    // Check if book is in user's favorites
                    $isFavorite = false;
                    if (isset($_SESSION['user_id'])) {
                        $userId = $_SESSION['user_id'];
                        $bookId = $book['book_id'];
                        $favoriteCheck = mysqli_query($conn, "SELECT fav_id FROM favourite WHERE user_id = $userId AND book_id = $bookId");
                        $isFavorite = mysqli_num_rows($favoriteCheck) > 0;
                    }
                ?>
                <div class="book-card book-container">
                  <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                  <?php if (!empty($book['book_cover'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo $book['book_cover']; ?>" 
                    alt="Book Cover" class="cover-thumbnail">
                  <?php else: ?>
                    <img src="Assets/Images/default-book.jpg" 
                        alt="Default Cover" class="cover-thumbnail">
                  <?php endif; ?>
                  <div class="book-title"><?php echo htmlspecialchars($book['title']) ?></div>
                  <div class="book-author"><?php echo htmlspecialchars($book['author']) ?></div>
                  <div class="book-genre"><?php echo htmlspecialchars($book['genre']) ?></div>
                  <div class="book-desc"><?php echo htmlspecialchars($book['description']) ?></div>
                  <div class="availability">
                    <abbr title="Add to favourite" class="fav-container">
                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                        <i class="fas fa-star <?php echo $isFavorite ? 'favorited' : ''; ?>" id="fav"></i>
                    </abbr> 
                   <abbr title="Download to read later"><i class="fas fa-download" id="downld"></i></abbr>
                    <button>Read Now</button></div>
                </div>
                <?php endforeach; ?>
              </div>

              <script>
                const searchInput = document.getElementById('searchInput');
                const bookCards = document.querySelectorAll('.book-card');

                searchInput.addEventListener('input', function () {
                  const searchTerm = this.value.toLowerCase();

                  bookCards.forEach(card => {
                    const title = card.querySelector('.book-title').textContent.toLowerCase();
                    const author = card.querySelector('.book-author').textContent.toLowerCase();
                    const desc = card.querySelector('.book-desc').textContent.toLowerCase();

                    const match = title.includes(searchTerm) || author.includes(searchTerm) || desc.includes(searchTerm);

                    card.style.display = match ? 'block' : 'none';
                  });
                });
              </script>

              <script src="./Assets/Scripts/FavouriteBook.js"></script>
              <script src="./Assets/Scripts/languageManager.js"></script>
</body>
</html>