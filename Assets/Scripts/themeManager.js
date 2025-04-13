document.addEventListener('DOMContentLoaded', function() {
    // Theme definitions
    const themes = {
        default: {
            '--primary-bg': '#ffffff',
            '--secondary-bg': '#f4f4f4',
            '--primary-text': '#000000',
            '--secondary-text': '#101010',
            '--accent-color': '#3498DB',
            '--sidebar-bg': '#34495E',
            '--sidebar-text': '#ffffff',
            '--card-bg': '#ffffff',
            '--card-shadow': '0 4px 6px rgba(0, 0, 0, 0.1)',
            '--header-bg': '#3498DB',
            '--notification-bg': '#E74C3C'
        },
        light: {
            '--primary-bg': '#ffffff',
            '--secondary-bg': '#f8f9fa',
           '--primary-text': '#000000',
            '--secondary-text': '#101010',
            '--accent-color': '#3498DB',
            '--sidebar-bg': '#3498DB',
            '--sidebar-text': '#ffffff',
            '--card-bg': '#ffffff',
            '--card-shadow': '0 2px 4px rgba(0, 0, 0, 0.1)',
            '--header-bg': '#3498DB',
            '--notification-bg': '#E74C3C'
        },
        dark: {
            '--primary-bg': '#1a1a1a',
            '--secondary-bg': '#2d2d2d',
            '--primary-text': '#ffffff',
            '--secondary-text': '#f5f5f5',
            '--accent-color': '#3498DB',
            '--sidebar-bg': '#2C3E50',
            '--sidebar-text': '#ffffff',
            '--card-bg': '#2d2d2d',
            '--card-shadow': '0 4px 6px rgba(0, 0, 0, 0.3)',
            '--header-bg': '#2C3E50',
            '--notification-bg': '#C0392B'
        },
        booksphere: {
            '--primary-bg': '#f5e6d3',
            '--secondary-bg': '#fff8f0',
            '--primary-text': '#000000',
            '--secondary-text': '#101010',
            '--accent-color': '#8B4513',
            '--sidebar-bg': '#8B4513',
            '--sidebar-text': '#ffffff',
            '--card-bg': '#fff8f0',
            '--card-shadow': '0 4px 6px rgba(139, 69, 19, 0.2)',
            '--header-bg': '#8B4513',
            '--notification-bg': '#A0522D'
        }
    };

    // Function to apply theme
    function applyTheme(themeName) {
        const theme = themes[themeName];
        for (const [property, value] of Object.entries(theme)) {
            document.documentElement.style.setProperty(property, value);
        }
        localStorage.setItem('selectedTheme', themeName);
    }

    // Get theme inputs
    const themeInputs = document.querySelectorAll('input[name="theme"]');
    
    // Load saved theme or default
    const savedTheme = localStorage.getItem('selectedTheme') || 'default';
    
    // Set the correct radio button
    themeInputs.forEach(input => {
        if (input.value === savedTheme) {
            input.checked = true;
        }
    });

    // Apply saved theme
    applyTheme(savedTheme);

    // Add event listeners to theme inputs
    themeInputs.forEach(input => {
        input.addEventListener('change', (e) => {
            applyTheme(e.target.value);
        });
    });
});