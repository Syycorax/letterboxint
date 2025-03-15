<?php
require_once('functions.php');

// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';
$page = "Films";
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

// if add to watchlist button is clicked
if (isset($_POST['watch'])) {
    if (!isset($_POST['remove'])) {
        // Add movie to watchlist
        $movie_id = $_POST['movie_id'];
        $user = $_COOKIE['username'];
        $user_id = getUserIdByUsername($user, $pdo);
        $status = "to_watch";
        $sql = "INSERT INTO watchlist (user_id,status,movie_id) VALUES (:user_id,:status, :movie_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id, ':status' => $status, ':movie_id' => $movie_id]);
    } else {
        // Set movie as Seen
        $movie_id = $_POST['movie_id'];
        $user = $_COOKIE['username'];
        $user_id = getUserIdByUsername($user, $pdo);
        $status = "seen";
        $sql = "UPDATE watchlist SET status = :status WHERE user_id = :user_id AND movie_id = :movie_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id, ':status' => $status, ':movie_id' => $movie_id]);
    }
    // Refresh the page
    header("Location: index.php");
    exit();
}
require_once("header.php");
?>
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
                        echo '<a href="/movie?movie_id=' . $movie["movie_id"] . '">';
                        echo '<img src="' . $movie["poster_path"] . '" alt="' . $movie["title"] . '">';
                        echo '</a>';
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
                            echo '<button type="submit" name="watch" class="watchlist-btn">'."Mark as seen".'</button>';
                        } elseif ($film_seen) {
                        } 
                        else {
                            echo '<input type="hidden" name="movie_id" value="' . $movie["movie_id"] . '">';
                            echo '<button type="submit" name="watch" class="watchlist-btn">'."add to watchlist".'</button>';
                        }
                        echo '</form>';
                        echo '<a href="/review?movie_id=' . $movie["movie_id"] . '" class="rating-btn">Add review</a>';                        
                        echo '</div>';
                    }
                    
                } else {
                    echo "No trending films found.";
                }
                ?>
            </div>
        </section>
    </main>

    <script src="script.js"></script>
</body>
<? require_once("footer.php");?>
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