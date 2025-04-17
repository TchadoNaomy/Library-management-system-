//  scripts for 

document.addEventListener('DOMContentLoaded', function() {
    // Get all password input fields and their corresponding icons
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    const toggleIcons = document.querySelectorAll('.fa-lock');

    // Add click event listeners to each icon
    toggleIcons.forEach((icon, index) => {
        icon.style.cursor = 'pointer';
        
        icon.addEventListener('click', () => {
            const input = passwordInputs[index];
            
            // Toggle password visibility
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-lock');
                icon.classList.add('fa-lock-open');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-lock-open');
                icon.classList.add('fa-lock');
            }
        });
    });
});