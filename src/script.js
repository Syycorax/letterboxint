// Sample movie data (would normally come from an API)
const trendingFilms = [
    { title: 'Dune: Part Two', poster: 'dune.jpg', rating: 8.7 },
    { title: 'Poor Things', poster: 'poor-things.jpg', rating: 8.5 },
    { title: 'Past Lives', poster: 'past-lives.jpg', rating: 8.2 },
    { title: 'Anatomy of a Fall', poster: 'anatomy.jpg', rating: 8.0 },
    { title: 'The Zone of Interest', poster: 'zone.jpg', rating: 7.9 },
    { title: 'Oppenheimer', poster: 'oppenheimer.jpg', rating: 8.4 }
];
let currentUser = null;

// User class to simulate user data
class User {
    constructor(username, avatarUrl) {
        this.username = username;
        this.avatarUrl = avatarUrl || 'https://api.dicebear.com/8.x/avataaars/svg?seed=' + username;
    }
}
function updateAuthUI() {
    const authButtons = document.getElementById('auth-buttons');
    const userProfile = document.getElementById('user-profile');
    const start_button = document.getElementById('start');
    if (currentUser) {
        // Show user profile
        authButtons.classList.add('hidden');
        userProfile.classList.remove('hidden');
        
        // Set avatar and username
        const avatarImg = userProfile.querySelector('.avatar');
        const usernameSpan = userProfile.querySelector('.username');
        
        avatarImg.src = currentUser.avatarUrl;
        usernameSpan.textContent = currentUser.username;
        start_button.hidden = true;
    } else {
        // Show sign in/up buttons
        authButtons.classList.remove('hidden');
        userProfile.classList.add('hidden');
        start_button.hidden = false;
    }
}

const recentReviews = [
    { 
        user: 'CinemaFan23', 
        movie: 'Dune: Part Two', 
        review: 'An epic sci-fi masterpiece. Denis Villeneuve continues to amaze.', 
        rating: 5 
    },
    { 
        user: 'MovieBuff', 
        movie: 'Poor Things', 
        review: 'Bizarre, brilliant, and utterly unique. Emma Stone is phenomenal.', 
        rating: 4.5 
    }
];

const popularLists = [
    { 
        title: 'Best Sci-Fi of 2024', 
        creator: 'SciFiNerd', 
        movies: ['Dune: Part Two', 'Civil War', 'M3GAN'] 
    },
    { 
        title: 'Oscar Worthy Performances', 
        creator: 'AwardsSeason', 
        movies: ['Poor Things', 'Maestro', 'Anatomy of a Fall'] 
    }
];

function renderTrendingFilms() {
    const filmGrid = document.getElementById('trending-films');
    trendingFilms.forEach(film => {
        const filmCard = document.createElement('div');
        filmCard.classList.add('film-card');
        filmCard.innerHTML = `
            <img src="${film.poster}" alt="${film.title}">
            <h3>${film.title}</h3>
            <p>Rating: ${film.rating}/10</p>
        `;
        filmGrid.appendChild(filmCard);
    });
}

function renderRecentReviews() {
    const reviewContainer = document.getElementById('recent-reviews');
    recentReviews.forEach(review => {
        const reviewCard = document.createElement('div');
        reviewCard.classList.add('review-card');
        reviewCard.innerHTML = `
            <h3>${review.movie}</h3>
            <p>${review.review}</p>
            <div class="review-meta">
                <span>By ${review.user}</span>
                <span>Rating: ${review.rating}/5</span>
            </div>
        `;
        reviewContainer.appendChild(reviewCard);
    });
}

function renderPopularLists() {
    const listsGrid = document.getElementById('popular-lists');
    popularLists.forEach(list => {
        const listCard = document.createElement('div');
        listCard.classList.add('list-card');
        listCard.innerHTML = `
            <h3>${list.title}</h3>
            <p>Created by ${list.creator}</p>
            <ul>
                ${list.movies.map(movie => `<li>${movie}</li>`).join('')}
            </ul>
        `;
        listsGrid.appendChild(listCard);
    });
}

// Render content when page loads
document.addEventListener('DOMContentLoaded', () => {
    renderTrendingFilms();
    renderRecentReviews();
    renderPopularLists();
});

// Add to existing script.js content
function createAuthModal(type) {
    // Remove any existing modal first
    const existingModal = document.querySelector('.auth-modal');
    if (existingModal) {
        existingModal.remove();
    }

    // Create modal container
    const modal = document.createElement('div');
    modal.classList.add('auth-modal');
    
    // Set up form based on type (sign in or sign up)
    const isSignUp = type === 'signup';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>${isSignUp ? 'Sign Up' : 'Sign In'}</h2>
            <form id="auth-form" action="${isSignUp ? 'register.php' : 'login.php'}" method="POST">
                ${isSignUp ? `
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                ` : ''}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                ${isSignUp ? `
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" required>
                    </div>
                ` : ''}
                <button type="submit">${isSignUp ? 'Create Account' : 'Sign In'}</button>
            </form>
            <div class="modal-footer">
                ${isSignUp 
                    ? `Already have an account? <a href="#" id="switch-to-signin">Sign In</a>`
                    : `Don't have an account? <a href="#" id="switch-to-signup">Sign Up</a>`
                }
            </div>
        </div>
    `;

    // Append to body
    document.body.appendChild(modal);

    // Close modal when clicking X
    modal.querySelector('.close-modal').addEventListener('click', () => {
        modal.remove();
    });

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
        }
    });

    // Form submission handler
    const form = modal.querySelector('#auth-form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Basic client-side validation
        if (isSignUp) {
            const password = form.querySelector('#password').value;
            const confirmPassword = form.querySelector('#confirm-password').value;
            
            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return;
            }
        }

        // Use Fetch API to submit form
        const formData = new FormData(form);
        
        fetch(isSignUp ? 'register.php' : 'login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Handle successful registration/login
                alert(data.message);
                
                // Update UI or redirect
                if (isSignUp) {
                    // For sign up, you might want to auto-login or show a success message
                    currentUser = new User(
                        formData.get('username') || 'User', 
                        formData.get('email')
                    );
                    updateAuthUI();
                } else {
                    // For login, handle redirect or UI update
                    window.location.href = data.redirect || '/dashboard.php';
                }
                
                // Close the modal
                modal.remove();
            } else {
                // Handle errors
                alert(data.message || 'Authentication failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again', error);
        });
    });

    // Switch between sign in and sign up
    const switchLink = modal.querySelector('#switch-to-signin, #switch-to-signup');
    if (switchLink) {
        switchLink.addEventListener('click', (e) => {
            e.preventDefault();
            modal.remove();
            createAuthModal(isSignUp ? 'signin' : 'signup');
        });
    }
}
// Add event listeners to sign in and sign up buttons
document.addEventListener('DOMContentLoaded', () => {
    // Existing render functions...
    // if cookie exists, set currentUser
    if(document.cookie.includes('username')) {
        // username = username cookie vlaue
        username = document.cookie.split('=')[1];
        currentUser = new User(username);
        updateAuthUI();
    }
    // Add authentication modal event listeners
    const signinBtn = document.querySelector('.login-btn');
    const signupBtns = document.querySelectorAll('.signup-btn, .signup-large');
    const signoutBtn = document.querySelector('.logout-btn');

    signinBtn.addEventListener('click', () => createAuthModal('signin'));
    signupBtns.forEach(btn => {
        btn.addEventListener('click', () => createAuthModal('signup'));
    });
    signoutBtn.addEventListener('click', () => {
        // Clear username cookie
        document.cookie = 'username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        currentUser = null;
        updateAuthUI();
    });
});

