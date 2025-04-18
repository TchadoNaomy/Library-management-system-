document.addEventListener('DOMContentLoaded', function() {
    // Debug: Check if elements are found
    console.log('DOM Content Loaded');
    
    const addBookBtn = document.getElementById('add-book-btn');
    const bookModal = document.getElementById('book-modal');
    const closeBtn = bookModal.querySelector('.close-btn');
    const bookForm = document.getElementById('book-form');
    const modalTitle = document.getElementById('modal-title');

    console.log('Add Book Button:', addBookBtn);
    console.log('Book Modal:', bookModal);

    // Show modal when Add Book button is clicked
    addBookBtn.addEventListener('click', function() {
        console.log('Add Book button clicked');
        modalTitle.textContent = 'Add Book';
        bookForm.reset(); // Clear form
        bookModal.style.display = 'flex';
        bookModal.style.opacity = '1';
        bookModal.style.visibility = 'visible';
    });

    // Close modal when X is clicked
    closeBtn.addEventListener('click', function() {
        bookModal.style.display = 'none';
        bookModal.style.opacity = '0';
        bookModal.style.visibility = 'hidden';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === bookModal) {
            bookModal.style.display = 'none';
            bookModal.style.opacity = '0';
            bookModal.style.visibility = 'hidden';
        }
    });

    // Handle form submission
    bookForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const bookId = document.getElementById('book-id').value;
        const formData = new FormData(this);
        
        try {
            const response = await fetch(
                bookId ? '../../Backend/Admin/updateBook.php' : '../../Backend/Admin/addBook.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

            const data = await response.json();
            
            if (data.success) {
                alert(data.message);
                bookModal.style.display = 'none';
                location.reload(); // Refresh to show changes
            } else {
                alert(data.message || 'Failed to save book');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the book');
        }
    });

    // Edit book functionality
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            console.log('Edit button clicked'); // Debug log
            
            const bookId = this.getAttribute('data-id');
            console.log('Book ID:', bookId); // Debug log
            
            modalTitle.textContent = 'Edit Book';
            
            try {
                const response = await fetch(`../../Backend/Admin/getBook.php?id=${bookId}`);
                const data = await response.json();
                
                console.log('Fetched data:', data); // Debug log
                
                if (data.success) {
                    // Populate form with book data
                    document.getElementById('book-id').value = data.book.book_id;
                    document.getElementById('title').value = data.book.title; // Changed from title to book_title
                    document.getElementById('author').value = data.book.author;
                    document.getElementById('publisher').value = data.book.publisher;
                    document.getElementById('publication_date').value = data.book.publication_date;
                    document.getElementById('ISBN').value = data.book.ISBN;
                    document.getElementById('quantity').value = data.book.quantity;
                    
                    // Show modal with all display properties
                    bookModal.style.display = 'flex';
                    bookModal.style.opacity = '1';
                    bookModal.style.visibility = 'visible';
                    
                    console.log('Modal should be visible now'); // Debug log
                } else {
                    alert(data.message || 'Failed to fetch book details');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while fetching book details');
            }
        });
    });

    // Delete book functionality
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const bookId = this.getAttribute('data-id');
            
            // Confirm deletion
            if (!confirm('Are you sure you want to delete this book?')) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('book_id', bookId);

                const response = await fetch('../../Backend/Admin/deleteBook.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    // Remove the row from the table
                    this.closest('tr').remove();
                    
                    // If no books left, show "No books found" message
                    const tbody = document.querySelector('.table tbody');
                    if (tbody.children.length === 0) {
                        const noDataRow = document.createElement('tr');
                        noDataRow.innerHTML = '<td colspan="10" class="no-data">No books found</td>';
                        tbody.appendChild(noDataRow);
                    }
                } else {
                    alert(data.message || 'Failed to delete book');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting the book');
            }
        });
    });
});