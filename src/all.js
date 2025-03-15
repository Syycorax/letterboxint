class User {
    constructor(username, avatarUrl) {
        this.username = username;
        this.avatarUrl = avatarUrl || 'https://api.dicebear.com/8.x/avataaars/svg?seed=' + username;
    }
}
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
  console.log(document.cookie); // PHPSESSID=d33a10af7e94bfa1ba03a74bffd59370; username=bancho
  if (document.cookie.includes("username")) {
    // get username from cookie
    cookies = document.cookie.split(";")
    cookies.forEach(function(cookie) {
        if (cookie.includes("username")) {
            username = cookie.split("=")[1];
        }
    });
    if (username) {
        currentUser = new User(username);
        updateAuthUI();
    } else {
        console.error("Username invalid");
    }
  } else {
    console.log("No username cookie");
  }
  // Add authentication modal event listeners
  const signinBtn = document.querySelector(".login-btn");
  const signupBtns = document.querySelectorAll(".signup-btn, .signup-large");
  const signoutBtn = document.querySelector(".logout-btn");

  signinBtn.addEventListener("click", () => createAuthModal("signin"));
  signupBtns.forEach((btn) => {
    btn.addEventListener("click", () => createAuthModal("signup"));
  });
  signoutBtn.addEventListener("click", () => {
    // Clear username cookie
    document.cookie =
      "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    currentUser = null;
    updateAuthUI();
  });
});

function updateAuthUI() {
    const authButtons = document.getElementById('auth-buttons');
    const userProfile = document.getElementById('user-profile');
    if (currentUser) {
        // Show user profile
        authButtons.classList.add('hidden');
        userProfile.classList.remove('hidden');
        
        // Set avatar and username
        const avatarImg = userProfile.querySelector('.avatar');
        const usernameSpan = userProfile.querySelector('.username');
        
        avatarImg.src = currentUser.avatarUrl;
        usernameSpan.textContent = currentUser.username;
    } else {
        // Show sign in/up buttons
        authButtons.classList.remove('hidden');
        userProfile.classList.add('hidden');
    }
}