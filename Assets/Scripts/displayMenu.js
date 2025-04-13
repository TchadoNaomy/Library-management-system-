document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.querySelector('.mobileMenu');
    const sideBar = document.querySelector('.sideBar');
    const MOBILE_BREAKPOINT = 1024; // Changed breakpoint to 1024px

    // Function to handle mobile menu display
    function handleMobileMenuDisplay() {
        if (window.innerWidth <= MOBILE_BREAKPOINT) {
            mobileMenu.style.display = 'flex';
        } else {
            mobileMenu.style.display = 'none';
            sideBar.classList.remove('show');
        }
    }

    // Initial check for mobile view
    handleMobileMenuDisplay();

    // Toggle sidebar when mobile menu is clicked
    mobileMenu.addEventListener('click', function(e) {
        e.stopPropagation();
        sideBar.classList.toggle('show');
    });

    // Close sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (!sideBar.contains(e.target) && !mobileMenu.contains(e.target)) {
            sideBar.classList.remove('show');
        }
    });

    // Handle window resize
    window.addEventListener('resize', handleMobileMenuDisplay);
});