<?php
require_once('../functions.php');

$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';
$page = "Watchlist";

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
    <?php require_once("../header.php")?>
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
<?php require_once("../footer.php");?>

    <script src="../script.js"></script>
</body>
</html>