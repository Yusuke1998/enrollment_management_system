/**
 * Login Page Token Handler
 * 
 * This script handles the authentication token on the login page.
 * It checks for the token in the session and stores it in localStorage.
 */

document.addEventListener('DOMContentLoaded', function() {
    const tokenElement = document.getElementById('auth-token');
    if (tokenElement && tokenElement.value) {
        localStorage.setItem('auth_token', tokenElement.value);
    }
}); 