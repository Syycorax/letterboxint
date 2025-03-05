<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letterboxd</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Letterboxd</div>
            <div class="nav-links">
                <a href="#">Films</a>
                <a href="#">Lists</a>
                <a href="#">Network</a>
                <a href="#">Reviews</a>
            </div>
            <div class="user-actions">
                <input type="search" placeholder="Search movies, lists, people...">
                <div id="auth-buttons">
                    <button class="login-btn">Sign In</button>
                    <button class="signup-btn">Sign Up</button>
                </div>
                <div id="user-profile" class="user-profile hidden">
                    <a href="/profile" class="profile-link">
                        <img src="" alt="User Avatar" class="avatar">
                        <span class="username"></span>
                    </a>
                    <button class="logout-btn">Logout</button>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Track films you've watched. Save those you want to see. Tell your friends what's good.</h1>
            <div class="hero-cta">
                <button class="signup-large" id="start">Start Tracking</button>
            </div>
        </section>

        <section class="trending-films">
            <h2>Trending This Week</h2>
            <div class="film-grid" id="trending-films">
                <!-- Films will be dynamically populated by JavaScript -->
            </div>
        </section>

        <section class="recent-reviews">
            <h2>Recent Reviews</h2>
            <div class="reviews-container" id="recent-reviews">
                <!-- Reviews will be dynamically populated by JavaScript -->
            </div>
        </section>

        <section class="popular-lists">
            <h2>Popular Lists</h2>
            <div class="lists-grid" id="popular-lists">
                <!-- Lists will be dynamically populated by JavaScript -->
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-links">
            <a href="#">About</a>
            <a href="#">Help</a>
            <a href="#">Terms</a>
            <a href="#">Privacy</a>
        </div>
        <div class="social-links">
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
            <a href="#">Facebook</a>
        </div>
        <p>&copy; 2024 Letterboxd Limited</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
