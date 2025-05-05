// Add favorite functionality
document.addEventListener('click', async function(e) {
    const favIcon = e.target.closest('#fav');
    if (favIcon) {
        e.preventDefault();
        
        // Find the nearest parent container and get the book_id
        const favContainer = favIcon.closest('.fav-container');
        if (!favContainer) {
            console.error('Favorite container not found');
            return;
        }

        const bookIdInput = favContainer.querySelector('input[name="book_id"]');
        if (!bookIdInput) {
            console.error('Hidden input for book_id not found');
            alert('Could not process this request. Please try again.');
            return;
        }

        const bookId = bookIdInput.value;

        // Show loading state
        const originalContent = favIcon.className;
        favIcon.className = 'fas fa-spinner fa-spin';

        try {
            const formData = new FormData();
            formData.append('book_id', bookId);

            const response = await fetch('/Library-management-system-/Backend/User/favBookhandler.php', {
                method: 'POST',
                body: formData
            });

            // Check if response is OK and is JSON
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Received non-JSON response from server');
            }

            const data = await response.json();

            if (data.success) {
                // Update icon appearance
                favIcon.className = 'fas fa-star favorited';
                alert(data.message);
            } else {
                throw new Error(data.message || 'Failed to add to favorites');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message);
            // Reset icon state
            favIcon.className = originalContent;
        }
    }
});