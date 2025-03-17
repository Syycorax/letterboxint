<?php
require_once('../functions.php');

// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';
$page = "Watchlist";

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    require_once("../header.php");
    // Check if user is logged in
    if (!isset($_COOKIE['username'])) {?>
        <div class="reviews-container">
            <div class="login-required">
                <h2>Don't know what to watch tonight ?</h2>
                <p>Sign in to keep track of your watchlist</p>
                <button class="login-btn start-reviewing">Sign In</button>
            </div>
        </div>
        <?php
        require_once("../footer.php");
        exit();
    }

    $username = $_COOKIE['username'];
    $user_id = getUserIdByUsername($username, $pdo);
    
    // Fetch trending movies
    $sql = "SELECT movie_id,title, poster_path FROM movie";
    $stmt = $pdo->query($sql);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch the watchlist for the current user
$sql = "SELECT * FROM watchlist 
        JOIN movie ON watchlist.movie_id = movie.movie_id 
        WHERE watchlist.user_id = :user_id AND watchlist.status = 'to_watch'";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$watchlist = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <?php require_once("../header.php")?>
    <main>
        <section class="watchlist">
            <h2>Your watchlist</h2>
            <div class="film-grid" id="watchlist">
                <?php
                if (!empty($watchlist)) {
                    foreach ($watchlist as $movie) {
                        echo createMovieCard($movie, $pdo);
                    }
                } else {
                    echo "Your watchlist is empty !<br>Add some movies to it :)";
                }
                ?>
            </div>
        </section>
    </main>
<?php require_once("../footer.php");?>

    <script src="../script.js"></script>
</body>
</html>