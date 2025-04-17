// script for the form toggling

document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const toggleBtn = document.querySelector('.togglebtn');
    const signUpForm = document.querySelector('.signUpform');
    const loginForm = document.querySelector('.loginform');
    const linkText = document.querySelector('.Link p');

    // Get stored form state or default to signup
    const currentForm = sessionStorage.getItem('currentForm') || 'signup';

    // Set initial state based on stored value
    if (currentForm === 'login') {
        signUpForm.style.display = 'none';
        loginForm.style.display = 'flex';
        toggleBtn.textContent = 'Sign Up';
        linkText.innerHTML = 'Don\'t have an account? ';
    } else {
        loginForm.style.display = 'none';
        signUpForm.style.display = 'flex';
        toggleBtn.textContent = 'Login';
        linkText.innerHTML = 'Already have an account? ';
    }
    linkText.appendChild(toggleBtn);

    // Handle toggle button click
    toggleBtn.addEventListener('click', function() {
        const isSignUpVisible = signUpForm.style.display === 'flex';
        
        if (isSignUpVisible) {
            signUpForm.style.display = 'none';
            loginForm.style.display = 'flex';
            toggleBtn.textContent = 'Sign Up';
            linkText.innerHTML = 'Don\'t have an account? ';
            sessionStorage.setItem('currentForm', 'login');
        } else {
            loginForm.style.display = 'none';
            signUpForm.style.display = 'flex';
            toggleBtn.textContent = 'Login';
            linkText.innerHTML = 'Already have an account? ';
            sessionStorage.setItem('currentForm', 'signup');
        }
        linkText.appendChild(toggleBtn);
    });
});