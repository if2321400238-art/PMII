/**
 * Admin-specific JavaScript
 * Minimal version for admin panel - no frameworks loaded
 * Axios will be loaded on-demand when needed for AJAX
 */

// CSRF token for any AJAX requests
document.addEventListener('DOMContentLoaded', function() {
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        window.csrfToken = token.getAttribute('content');
    }
});
