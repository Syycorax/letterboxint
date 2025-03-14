<?php
// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';
$page = "Reviews";
require_once('../functions.php');

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get movie information if movie_id is provided
    $movie = null;
    if (isset($_GET['movie_id'])) {
        $movie_id = $_GET['movie_id'];
        $sql = "SELECT movie_id, title, poster_path FROM movie WHERE movie_id = :movie_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':movie_id' => $movie_id]);
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Handle review submission
    if (isset($_POST['submit_review'])) {
        if (!isset($_COOKIE['username'])) {
            $error = "You must be logged in to submit a review";
        } else {
            $user = $_COOKIE['username'];
            $user_id = getUserIdByUsername($user, $pdo);
            $movie_id = $_POST['movie_id'];
            $note = $_POST['note'];  // Rating/note value
            $comment = $_POST['comment'];  // Review text/comment
            $date_published = date('Y-m-d H:i:s');
            
            // Check if user has already reviewed this movie
            $sql = "SELECT review_id FROM review WHERE user_id = :user_id AND movie_id = :movie_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id, ':movie_id' => $movie_id]);
            $existing_review = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existing_review) {
                // Update existing review
                $sql = "UPDATE review SET note = :note, comment = :comment, date_published = :date_published 
                        WHERE user_id = :user_id AND movie_id = :movie_id";
                $message = "Your review has been updated!";
            } else {
                // Insert new review
                $sql = "INSERT INTO review (user_id, movie_id, note, comment, date_published) 
                        VALUES (:user_id, :movie_id, :note, :comment, :date_published)";
                $message = "Your review has been submitted!";
                
                // Also mark the movie as seen in watchlist
                $checkSql = "SELECT * FROM watchlist WHERE user_id = :user_id AND movie_id = :movie_id";
                $checkStmt = $pdo->prepare($checkSql);
                $checkStmt->execute([':user_id' => $user_id, ':movie_id' => $movie_id]);
                $watchlistEntry = $checkStmt->fetch(PDO::FETCH_ASSOC);
                
                if ($watchlistEntry) {
                    $updateSql = "UPDATE watchlist SET status = 'seen' WHERE user_id = :user_id AND movie_id = :movie_id";
                    $updateStmt = $pdo->prepare($updateSql);
                    $updateStmt->execute([':user_id' => $user_id, ':movie_id' => $movie_id]);
                } else {
                    $insertSql = "INSERT INTO watchlist (user_id, movie_id, status) VALUES (:user_id, :movie_id, 'seen')";
                    $insertStmt = $pdo->prepare($insertSql);
                    $insertStmt->execute([':user_id' => $user_id, ':movie_id' => $movie_id]);
                }
            }
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':movie_id' => $movie_id,
                ':note' => $note,
                ':comment' => $comment,
                ':date_published' => $date_published
            ]);
            
            // Redirect to movie page or index
            header("Location: index.php?review_success=1");
            exit();
        }
    }
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Review | LetterboxINT</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        /* Star rating styles */
        .rating-container {
            margin: 20px 0;
        }
        .stars {
            display: inline-flex;
            flex-direction: row-reverse;
            font-size: 2em;
        }
        .stars input {
            display: none;
        }
        .stars label {
            color: #ddd;
            cursor: pointer;
            padding: 0 0.1em;
            transition: color 0.2s;
        }
        .stars label:hover,
        .stars label:hover ~ label,
        .stars input:checked ~ label {
            color: #f90;
        }
        
        /* Review form styles */
        .review-form {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #2c3440;
            border-radius: 5px;
        }
        .movie-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .movie-poster {
            width: 120px;
            margin-right: 20px;
            border-radius: 4px;
        }
        .movie-title {
            font-size: 1.5em;
            font-weight: bold;
        }
        textarea {
            width: 100%;
            min-height: 200px;
            padding: 10px;
            font-family: inherit;
            border: 1px solid #456;
            border-radius: 4px;
            background-color: #1d2631;
            color: #fff;
            margin-bottom: 20px;
            resize: vertical;
        }
        .submit-btn {
            background-color: #ff8000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .submit-btn:hover {
            background-color: #ff9a33;
        }
        .error-message {
            color: #ff6b6b;
            margin-bottom: 15px;
        }
        .placeholder-text {
            color: #aaa;
            font-style: italic;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        
        /* Header styles from index.php */
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
        
        /* Page specific styles */
        .page-title {
            text-align: center;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <?php require("../header.php");?>

    <main>
        <h1 class="page-title">Write Your Review</h1>
        
        <div class="review-form">
            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
                <?php exit(); ?>
            <?php endif; ?>
            
            <?php if ($movie): ?>
                <div class="movie-info">
                    <img src="<?php echo $movie['poster_path']; ?>" alt="<?php echo $movie['title']; ?>" class="movie-poster">
                    <div>
                        <h2 class="movie-title"><?php echo $movie['title']; ?></h2>
                    </div>
                </div>
            <?php elseif(!isset($_GET['review_success']) && !$error): ?>
                <p class="error-message">No movie selected. Please select a movie to review.</p>
            <?php endif; ?>
            <?php if (isset($_GET['review_success'])): ?>
                <?php $message = "Your review has been submitted!";?>
                <p class="success-message"><?php echo $message; ?></p>
            <?php endif; ?>
            <?php if ($movie): ?>
                <form method="post" action="index.php">
                    <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                    
                    <div class="rating-container">
                        <h3>Your Rating</h3>
                        <div class="stars">
                            <input type="radio" id="star5" name="note" value="5" required>
                            <label for="star5" title="5 stars">★</label>
                            <input type="radio" id="star4" name="note" value="4">
                            <label for="star4" title="4 stars">★</label>
                            <input type="radio" id="star3" name="note" value="3">
                            <label for="star3" title="3 stars">★</label>
                            <input type="radio" id="star2" name="note" value="2">
                            <label for="star2" title="2 stars">★</label>
                            <input type="radio" id="star1" name="note" value="1">
                            <label for="star1" title="1 star">★</label>
                        </div>
                    </div>
                    
                    <h3>Your Review</h3>
                    <p class="placeholder-text">Share your thoughts on the film. What did you like or dislike? What stood out to you?</p>
                    <textarea maxlength="2045" name="comment" placeholder="Write your review here..." required></textarea>
                    
                    <button type="submit" name="submit_review" class="submit-btn">Post Review</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
<?php require_once("../footer.php")?>

    <script>
        // Script to handle the star rating selection
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is logged in
            const authButtons = document.getElementById('auth-buttons');
            const userProfile = document.getElementById('user-profile');
            
            if (document.cookie.includes('username=')) {
                const username = document.cookie
                    .split('; ')
                    .find(row => row.startsWith('username='))
                    .split('=')[1];
                
                if (userProfile) {
                    userProfile.querySelector('.username').textContent = username;
                    authButtons.classList.add('hidden');
                    userProfile.classList.remove('hidden');
                    userProfile.querySelector('.avatar').src = `https://api.dicebear.com/8.x/avataaars/svg?seed=${username}`;
                }
            }
            
            // Make the stars interactive with hover effects
            const stars = document.querySelectorAll('.stars label');
            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    this.classList.add('hovered');
                });
                
                star.addEventListener('mouseout', function() {
                    this.classList.remove('hovered');
                });
            });
        });
    </script>
</body>
</html>