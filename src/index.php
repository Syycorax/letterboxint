<?php
require_once('functions.php');

// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'utilisateur';
$dbPassword = 'password';
$page = "Home";
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
            <h1>Track films you've watched.<br>Save those you want to see.<br>Tell your friends what's good.</h1>
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
                        echo createMovieCard($movie, $pdo);
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