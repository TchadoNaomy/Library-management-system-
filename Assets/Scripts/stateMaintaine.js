// Prevent browser back button
window.history.pushState(null, null, window.location.href);
window.addEventListener('popstate', function() {
    window.history.pushState(null, null, window.location.href);
});

// Prevent keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (
        (e.keyCode == 116) || // F5
        (e.ctrlKey && e.keyCode == 82) || // Ctrl + R
        (e.ctrlKey && e.keyCode == 78) || // Ctrl + N
        (e.ctrlKey && e.keyCode == 87) || // Ctrl + W
        (e.altKey && e.keyCode == 37) // Alt + Left arrow
    ) {
        e.preventDefault();
    }
});

// Prevent right-click context menu
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
});
