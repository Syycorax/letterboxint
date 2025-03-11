<?php
// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch trending movies
    $sql = "SELECT movie_id,title, poster_path FROM movie";
    $stmt = $pdo->query($sql);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LetterboxINT</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add custom styles for the header */
        nav {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            color: #fff;
        }
        .nav-container {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }
        .nav-links {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }
        .nav-links a {
            margin: 0 10px;
            color: #fff;
            text-decoration: none;
        }
        .user-actions {
            display: flex;
            align-items: center;
        }
        .user-actions input[type="search"] {
            margin-right: 10px;
            padding: 5px;
        }
        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }
        .spacer {
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">LetterboxINT</div>
            <div class="nav-links">
                <a href="#">Films</a>
                <a href="#">Watchlist</a>
                <a href="#">Friends</a>
                <a href="#">Reviews</a>
            </div>
            <div class="spacer"></div>
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
            <h1>Track films you've watched.
                <br>Save those you want to see.
                <br>Tell your friends what's good.
            </h1>
            <div class="hero-cta">
                <button class="signup-large login-btn" id="start">Start Tracking</button>
            </div>
        </section>

        <section class="trending-films">
            <h2>Trending This Week</h2>
            <div class="film-grid" id="trending-films">
                <?php
                if (!empty($movies)) {
                    foreach ($movies as $movie) {
                        echo '<div class="film-card">';
                        echo '<img src="' . $movie["poster_path"] . '" alt="' . $movie["title"] . '">';
                        echo '<h3>' . $movie["title"] . '</h3>';
                        echo '<form method="post" action="index.php">';
                        $film_in_user_watchlist = false;
                        $film_seen = false;
                        if (isset($_COOKIE['username'])) {
                            $user = $_COOKIE['username'];
                            $user_id = getUserIdByUsername($user, $pdo);
                            $sql = "SELECT * FROM watchlist WHERE user_id = :user_id AND movie_id = :movie_id AND status = 'to_watch'";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([':user_id' => $user_id, ':movie_id' => $movie["movie_id"]]);
                            $film_in_user_watchlist = $stmt->fetch(PDO::FETCH_ASSOC);
                            $sql = "SELECT * FROM watchlist WHERE user_id = :user_id AND movie_id = :movie_id AND status = 'seen'";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([':user_id' => $user_id, ':movie_id' => $movie["movie_id"]]);
                            $film_seen = $stmt->fetch(PDO::FETCH_ASSOC);
                        }
                        if ($film_in_user_watchlist) {
                            echo '<input type="hidden" name="remove" value="yes">';
                            echo '<input type="hidden" name="movie_id" value="' . $movie["movie_id"] . '">';
                            echo '<button type="submit" name="watch" class="watchlist-btn">'."Seen".'</button>';
                        } elseif ($film_seen) {
                        } 
                        else {
                            echo '<input type="hidden" name="movie_id" value="' . $movie["movie_id"] . '">';
                            echo '<button type="submit" name="watch" class="watchlist-btn">'."add to watchlist".'</button>';
                        }
                        echo '</form>';
                        echo '<a class="rating-btn" name="' . $movie["title"] . '">'."Add review".'</a>';
                        echo '</div>';
                    }
                    
                } else {
                    echo "No trending films found.";
                }
                ?>
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
<?php
// if add to watchlist button is clicked
if (isset($_POST['watch'])) {
    if (!isset($POST['remove'])) {
            // Add movie to watchlist
    $movie_id = $_POST['movie_id'];
    $user = $_COOKIE['username'];
    $user_id = getUserIdByUsername($user, $pdo);
    $status = "to_watch";
    $sql = "INSERT INTO watchlist (user_id,status,movie_id) VALUES (:user_id,:status, :movie_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id, ':status' => $status, ':movie_id' => $movie_id]);

    }
    else{
        // Set moovie as Seen
        $movie_id = $_POST['movie_id'];
        $user = $_COOKIE['username'];
        $user_id = getUserIdByUsername($user, $pdo);
        $status = "seen";
        $sql = "UPDATE watchlist SET status = :status WHERE user_id = :user_id AND movie_id = :movie_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id, ':status' => $status, ':movie_id' => $movie_id]);
    }
}

function getUserIdByUsername($username, $pdo) {
    $sql = "SELECT user_id FROM user_account WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['user_id'] : null;
}