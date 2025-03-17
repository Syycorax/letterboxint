<?php
require_once('../functions.php');

// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'utilisateur';
$dbPassword = 'password';
if (isset($_GET['user'])){
    $username = $_GET['user'];
} else {
    if (!isset($_COOKIE['username'])) {
        echo "You need to be logged in to view your profile.";
        exit;
    }
    else{
        $username = $_COOKIE['username'];
    }
}
try {
    // Create PDO connection
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    $sql = "SELECT COUNT(*) AS friends FROM friendship WHERE (user_id_A = :user_id OR user_id_B = :user_id) AND status = 'accepted'";
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
    <?php require_once("../header.php")?>

    <main class="profile-page">
        <section class="profile-header">
            <div class="profile-banner"></div>
            <div class="profile-info">
                <img src="https://api.dicebear.com/8.x/avataaars/svg?seed=<?php echo $username; ?>" alt="Profile Picture" class="large-avatar">
                <div class="profile-details">
                    <h1 class="username"><?php echo $username; ?></h1>
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
                </div>
            </div>
        </section>

        <!-- Rest of the HTML remains the same -->
        <section class="profile-navigation">
            <nav>
                <a href="/reviews?user=<?php echo $username; ?>">Reviews</a>
                <a href="/watchlist?user=<?php echo $username; ?>">Watchlist</a>
                <a href="/friends">Network</a>
            </nav>
        </section>

    </main>

    <?php require_once('../footer.php'); ?>

    <script src="script.js"></script>
</body>
</html>