document.addEventListener('DOMContentLoaded', function() {
    // ...existing code...

    // Function to update title and icon
    function updateTitleFromActiveLink() {
        // Find the active list item
        const activeListItem = document.querySelector('.sideBar nav ul li.active');
        const titleElement = document.querySelector('.mainContent nav .title');
        
        if (activeListItem && titleElement) {
            // Get the text and icon from active list item
            const activeLink = activeListItem.querySelector('a');
            const activeIcon = activeListItem.querySelector('i').className;
            
            // Update the title text (removing extra spaces)
            titleElement.innerHTML = `
                <i class="${activeIcon}"></i>
                ${activeLink.textContent.trim()}
            `;
        }
    }

    // Run on page load
    updateTitleFromActiveLink();

    // Optional: Update when clicking different nav items
    // const navItems = document.querySelectorAll('.sideBar nav ul li');
    // navItems.forEach(item => {
    //     item.addEventListener('click', function() {
            // Remove active class from all items
            // navItems.forEach(i => i.classList.remove('active'));
            // Add active class to clicked item
            // this.classList.add('active');
            // Update title
    //         updateTitleFromActiveLink();
    //     });
    // });
});