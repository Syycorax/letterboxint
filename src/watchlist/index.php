<?php
require_once('../functions.php');

$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';

// Check if user is logged in
if (!isset($_COOKIE['username'])) {
    echo "You need to be logged in to view your watchlist.";
    exit;
}

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

$user = $_COOKIE['username'];
$user_id = getUserIdByUsername($user, $pdo);

// Fetch the watchlist for the current user
$sql = "SELECT movie.title FROM watchlist 
        JOIN movie ON watchlist.movie_id = movie.movie_id 
        WHERE watchlist.user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $watchlist = [];
// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $watchlist[] = $row;
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist - LetterboxINT</title>
    <link rel="stylesheet" href="../style.css">
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
        <section class="watchlist">
            <h2>Your watchlist</h2>
            <div class="film-grid" id="watchlist">
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

    <script src="../script.js"></script>
</body>
</html>