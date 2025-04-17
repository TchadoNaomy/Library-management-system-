document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('account-search-input');
    const searchBtn = document.getElementById('account-search-btn');
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
            const text = row.textContent.toLowerCase();
            const shouldShow = text.includes(searchTerm);
            row.style.display = shouldShow ? '' : 'none';
            if (shouldShow) foundMatch = true;
        });

        // If no matches found, show "User not found" message
        if (!foundMatch && searchTerm !== '') {
            const noResultsRow = document.createElement('tr');
            noResultsRow.className = 'no-results-row';
            const noResultsCell = document.createElement('td');
            noResultsCell.colSpan = columnCount; // Dynamically set colspan based on table structure
            noResultsCell.textContent = 'User not found';
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