document.addEventListener('DOMContentLoaded', () => {
    // Function to get cookie value
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    // Get username from cookie
    const username = getCookie('username');

    if (username) {


        // Update avatar (using dynamic avatar generation)
        const avatarUrls = document.querySelectorAll('.avatar');
        avatarUrls.forEach(avatar => {
            avatar.src = `https://api.dicebear.com/8.x/avataaars/svg?seed=${username}`;
            avatar.alt = `${username}'s Avatar`;
        });

        // Logout functionality
        const logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', () => {
                // Clear username cookie
                document.cookie = 'username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                
                // Redirect to home or login page
                window.location.href = '/';
            });
        }
    } else {
        // If no username cookie, redirect to login or show login modal
        window.location.href = '/login.html'; // or call createAuthModal('signin')
    }
});