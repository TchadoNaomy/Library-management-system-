<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Catalogue</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 20px;
    }

    .search-bar {
      text-align: center;
      margin-bottom: 30px;
    }

    .search-bar input {
      width: 300px;
      padding: 10px;
      font-size: 16px;
    }

    .catalogue {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .book-card {
      background: white;
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center;
    }

    .book-card img {
      max-width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 4px;
    }

    .book-title {
      font-weight: bold;
      margin: 10px 0 5px;
    }

    .book-author {
      font-style: italic;
      color: #666;
      margin-bottom: 10px;
    }

    .book-desc {
      font-size: 14px;
      color: #555;
      margin-bottom: 10px;
    }

    .availability {
      background: #ffd700;
      color: black;
      font-weight: bold;
      padding: 10px;
      border-radius: 3px;
    }
    .container {
      color: aqua;
      font-weight: bold;
      margin-left:250px;
    }
  </style>
</head>
<body>
  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search books...">
  </div>

  <div class="catalogue" id="bookCatalogue">
    <div class="book-card">
      <img src="https://via.placeholder.com/200x180" alt="Book Image">
      <div class="book-title">The Great Gatsby</div>
      <div class="book-author">F. Scott Fitzgerald</div>
      <div class="book-desc">A novel set in the Roaring Twenties.</div>
      <div class="availability">Available</div>
    </div>

    <div class="book-card">
      <img src="https://via.placeholder.com/200x180" alt="Book Image">
      <div class="book-title">To Kill a Mockingbird</div>
      <div class="book-author">Harper Lee</div>
      <div class="book-desc">A powerful story of racial injustice.</div>
      <div class="availability">Checked Out</div>
    </div>

    <div class="book-card">
      <img src="https://via.placeholder.com/200x180" alt="Book Image">
      <div class="book-title">1984</div>
      <div class="book-author">George Orwell</div>
      <div class="book-desc">Dystopian novel about surveillance and control.</div>
      <div class="availability">Available</div>
    </div>

    <div class="book-card">
      <img src="https://via.placeholder.com/200x180" alt="Book Image">
      <div class="book-title">god plan</div>
      <div class="book-author">gabana</div>
      <div class="book-desc"> novel about life.</div>
      <div class="availability">Available</div>
    </div>

      <div class="book-card">
      <img src="https://via.placeholder.com/200x180" alt="Book Image">
      <div class="book-title">it is not what you have, it what you become</div>
      <div class="book-author">Mr Hassane</div>
      <div class="book-desc"> powerful story of  injustice in life.</div>
      <div class="availability">Checked Out</div>
    </div>

    <div class="book-card">
      <img src="https://via.placeholder.com/200x180" alt="Book Image">
      <div class="book-title">tokoss</div>
      <div class="book-author">Fally</div>
      <div class="book-desc">the goodness of music.</div>
      <div class="availability">Available</div>
    </div>

    <div class="book-card">
      <img src="https://via.placeholder.com/200x180" alt="Book Image">
      <div class="book-title">it is future</div>
      <div class="book-author">Me</div>
      <div class="book-desc"> what a word.</div>
      <div class="availability">Checked Out</div>
    </div>

    <div class="book-card">
      <img src="https://via.placeholder.com/200x180" alt="Book Image">
      <div class="book-title">fuck life</div>
      <div class="book-author">us</div>
      <div class="book-desc"> sensational.</div>
      <div class="availability">Checked Out</div>
    </div>
    <!-- Add more book cards here -->

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

</body>
</html>