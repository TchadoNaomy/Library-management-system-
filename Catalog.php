<?php
require_once './Backend/login_handler.php';
// checkSession();
include_once './Backend/User/dashboardhandler.php';
include_once './Backend/Admin/fetchBooks.php';

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
                <li><a href="index.php">Home</a></li>
                <li><a href="aboutus.php">About</a></li>
                <li><a class="active" href="Catalog.php">Catalog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <div class="buttonContainer">
        <?php if (isset($_SESSION['user_role']) == 'client'): ?>
            <a href="./Dashboards/User/User.php"><button class="dashBoard">Dashboard</button></a>
            <?php else: ?>
           <a href="Register.php"><button class="signupbtn" >SignUp</button></a> 
            <?php endif; ?>
        </div>
    </header>
<body>
  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search books...">
  </div>

  <div class="catalogue" id="bookCatalogue">
    <?php foreach ($info as $book): ?>
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
            <i class="fas fa-star" id="fav"></i>
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

</body>
</html>