document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('book-search-input');
    const searchBtn = document.getElementById('book-search-btn');
    const tableRows = document.querySelectorAll('.table tbody tr');
    const tbody = document.querySelector('.table tbody');

    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let foundMatch = false;

        // Get the number of columns from the table header
        const columnCount = document.querySelectorAll('.table thead th').length;

        // Remove existing "no results" row if it exists
        const existingNoResults = document.querySelector('.no-results-row');
        if (existingNoResults) {
            existingNoResults.remove();
        }

        tableRows.forEach(row => {
            // Search in title, author, ISBN, and publisher
            const title = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const author = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const publisher = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
            const isbn = row.querySelector('td:nth-child(7)').textContent.toLowerCase();

            const shouldShow = title.includes(searchTerm) || 
                             author.includes(searchTerm) || 
                             publisher.includes(searchTerm) || 
                             isbn.includes(searchTerm);

            row.style.display = shouldShow ? '' : 'none';
            if (shouldShow) foundMatch = true;
        });

        // If no matches found, show "Book not found" message
        if (!foundMatch && searchTerm !== '') {
            const noResultsRow = document.createElement('tr');
            noResultsRow.className = 'no-results-row';
            const noResultsCell = document.createElement('td');
            noResultsCell.colSpan = columnCount; // Dynamically set colspan based on table structure
            noResultsCell.textContent = 'Book not found';
            noResultsCell.style.textAlign = 'center';
            noResultsCell.style.padding = '20px';
            noResultsCell.style.color = '#666';
            noResultsRow.appendChild(noResultsCell);
            tbody.appendChild(noResultsRow);
        }
    }

    // Search on button click
    searchBtn.addEventListener('click', performSearch);

    // Search as user types (optional)
    searchInput.addEventListener('keyup', function(e) {
        // Perform search on Enter key
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    // Clear search when input is cleared
    searchInput.addEventListener('input', function() {
        if (this.value === '') {
            tableRows.forEach(row => row.style.display = '');
            const noResultsRow = document.querySelector('.no-results-row');
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }
    });
});