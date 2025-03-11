<?php
require_once('../functions.php');

// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';

// Check if user is logged in
if (!isset($_COOKIE['username'])) {
    echo "You need to be logged in to view your profile.";
    exit;
}

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_COOKIE['username'];
    $user_id = getUserIdByUsername($username, $pdo);

    // Fetch the number of films watched
    $sql = "SELECT COUNT(*) AS films_watched FROM watchlist WHERE user_id = :user_id AND status = 'seen'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $films_watched = $stmt->fetch(PDO::FETCH_ASSOC)['films_watched'];

    // Fetch the number of films in the watchlist
    $sql = "SELECT COUNT(DISTINCT movie_id) AS films_in_watchlist FROM watchlist WHERE user_id = :user_id AND status = 'to_watch'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $films_in_watchlist = $stmt->fetch(PDO::FETCH_ASSOC)['films_in_watchlist'];

    // Fetch the number of friends
    $sql = "SELECT COUNT(*) AS friends FROM friendship WHERE (user_id_A = :user_id OR user_id_B = :user_id) AND status = 'Actif'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $friends = $stmt->fetch(PDO::FETCH_ASSOC)['friends'];

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Letterboxd</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Letterboxd</div>
            <div class="nav-links">
                <a href="/">Home</a>
                <a href="#">Films</a>
                <a href="#">Lists</a>
                <a href="#">Network</a>
            </div>
            <div class="user-actions">
                <input type="search" placeholder="Search movies, lists, people...">
                <div id="user-profile" class="user-profile">
                    <a href="/profile" class="profile-link">
                        <img src="" alt="User Avatar" class="avatar">
                        <span class="username">User</span>
                    </a>
                    <button class="logout-btn">Logout</button>
                </div>
            </div>
        </nav>
    </header>

    <main class="profile-page">
        <section class="profile-header">
            <div class="profile-banner"></div>
            <div class="profile-info">
                <img src="" alt="Profile Avatar" class="large-avatar">
                <div class="profile-details">
                    <h1 class="username">User</h1>
                    <p>Film enthusiast | Critic | Cinephile</p>
                    <div class="profile-stats">
                        <div class="stat">
                            <strong><?php echo $films_watched; ?></strong>
                            <span>Films watched</span>
                        </div>
                        <div class="stat">
                            <strong><?php echo $films_in_watchlist; ?></strong>
                            <span>Films in Watchlist</span>
                        </div>
                        <div class="stat">
                            <strong><?php echo $friends; ?></strong>
                            <span>Friends</span>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="edit-profile-btn">Edit Profile</button>
                        <button class="follow-btn">Follow</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Rest of the HTML remains the same -->
        <section class="profile-navigation">
            <nav>
                <a href="#" class="active">Films</a>
                <a href="#">Reviews</a>
                <a href="#">Lists</a>
                <a href="#">Watchlist</a>
                <a href="#">Network</a>
            </nav>
        </section>

        <!-- Previous content remains unchanged -->
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
        <p>&copy; 2024 Letterboxint Limited</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>