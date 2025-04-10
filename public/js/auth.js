/**
 * Authentication Token Management
 * 
 * This script handles the authentication token for API requests.
 * It checks for the token in cookies and localStorage, and provides
 * functions to get and set the token.
 */

function getAuthToken() {
    const storedToken = localStorage.getItem('auth_token');
    if (storedToken) {
        return storedToken;
    }
    
    console.log('Cookies disponibles:', document.cookie);
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        if (cookie.startsWith('auth_token=')) {
            const encodedToken = cookie.substring('auth_token='.length);
            const token = decodeURIComponent(encodedToken);
            localStorage.setItem('auth_token', token);
            return token;
        }
    }
    
    console.error('La cookie auth_token no fue encontrada.');
    return null;
}

function setAuthToken(token) {
    console.log('setAuthToken called. Setting token:', token);
    if (token) {
        localStorage.setItem('auth_token', token);
    } else {
        localStorage.removeItem('auth_token');
    }
}

function isAuthenticated() {
    console.log('isAuthenticated called. Checking token presence.');
    return !!getAuthToken();
}

function redirectToLoginIfNotAuthenticated() {
    console.log('redirectToLoginIfNotAuthenticated called. Checking authentication status.');
    if (!isAuthenticated()) {
        window.location.href = '/login';
        return false;
    }
    return true;
}

function getAuthHeaders() {
    const token = getAuthToken();
    return {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': token ? `Bearer ${token}` : ''
    };
}

function logout() {
    const token = getAuthToken();
    
    if (token) {
        fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            setAuthToken(null);
            
            window.location.href = '/login';
        })
        .catch(error => {
            console.error('Error during logout:', error);
            setAuthToken(null);
            window.location.href = '/login';
        });
    } else {
        window.location.href = '/login';
    }
}

window.auth = {
    getToken: getAuthToken,
    setToken: setAuthToken,
    isAuthenticated: isAuthenticated,
    redirectToLoginIfNotAuthenticated: redirectToLoginIfNotAuthenticated,
    getAuthHeaders: getAuthHeaders,
    logout: logout
}; 