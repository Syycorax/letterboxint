<?php
// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';
if (!isset($getUserIdByUsername)) {
    require_once("../functions.php");
}
$page = "Reviews";

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if user is logged in
    $user_reviews = [];
    $is_logged_in = isset($_COOKIE['username']);
    
    if ($is_logged_in) {
        $username = $_COOKIE['username'];
        $user_id = getUserIdByUsername($username, $pdo);
        
        // Fetch all reviews by the user with movie details
        $sql = "SELECT r.review_id, r.note, r.comment, r.date_published, 
                       m.movie_id, m.title, m.poster_path 
                FROM review r 
                JOIN movie m ON r.movie_id = m.movie_id 
                WHERE r.user_id = :user_id 
                ORDER BY r.date_published DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $user_reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Handle review deletion if requested
    if (isset($_POST['delete_review']) && $is_logged_in) {
        $review_id = $_POST['review_id'];
        $sql = "DELETE FROM review WHERE review_id = :review_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':review_id' => $review_id, ':user_id' => $user_id]);
        
        // Redirect to refresh the page
        header("Location: index.php?deleted=1");
        exit();
    }
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// Format date to a more readable format
function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('F j, Y');
}

// Generate star rating HTML
function generateStarRating($rating) {
    $html = '<div class="star-rating">';
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $html .= '<span class="star filled">★</span>';
        } else {
            $html .= '<span class="star">☆</span>';
        }
    }
    
    $html .= '</div>';
    return $html;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reviews | LetterboxINT</title>
    <link rel="stylesheet" href="../style.css">
    <style>
            /* Review list styles */
        .reviews-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .review-card {
            background-color: #2c3440;
            border-radius: 5px;
            margin-bottom: 25px;
            padding: 20px;
            display: flex;
            position: relative;
            /* No width constraints to allow natural flow */
        }

        .review-poster {
            width: 100px;
            min-width: 100px;
            border-radius: 4px;
            margin-right: 20px;
            height: 100%;
        }

        .review-content {
            flex-grow: 1;
            min-width: 0; /* This is crucial - allows the content to shrink below its natural width */
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .review-title {
            font-size: 1.4em;
            font-weight: bold;
            margin: 0;
        }

        .review-date {
            color: #aaa;
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .star-rating {
            margin: 10px 0;
            font-size: 1.2em;
        }

        .star {
            color: #ddd;
            margin-right: 2px;
        }

        .star.filled {
            color: #f90;
        }

        .review-text {
            margin: 15px 0;
            line-height: 1.6;
            white-space: pre-line;
        }

        .review-actions {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap; /* Allow buttons to wrap to next line when space is limited */
            gap: 10px;
        }

        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border-radius: 3px;
            font-size: 0.9em;
            cursor: pointer;
            background: none;
            border: 1px solid;
        }

        .edit-btn {
            border-color: #40bcf4;
            color: #40bcf4;
        }

        .delete-btn {
            border-color: #ff6b6b;
            color: #ff6b6b;
        }

        .edit-btn:hover {
            background-color: #40bcf41a;
        }

        .delete-btn:hover {
            background-color: #ff6b6b1a;
        }

        .login-required {
            text-align: center;
            padding: 40px 20px;
            background-color: #2c3440;
            border-radius: 5px;
        }

        .page-title {
            text-align: center;
            margin: 30px 0;
        }

        .alert {
            background-color: #4caf5033;
            color: #4caf50;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        .empty-reviews {
            text-align: center;
            padding: 30px;
            background-color: #2c3440;
            border-radius: 5px;
            color: #aaa;
        }

        .start-reviewing {
            margin-top: 20px;
            display: inline-block;
            background-color: #ff8000;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }

        .delete-confirm-dialog {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }

        .delete-confirm-content {
            background-color: #2c3440;
            padding: 20px;
            border-radius: 5px;
            max-width: 400px;
            width: 100%;
        }

        .delete-confirm-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .delete-confirm-cancel {
            padding: 8px 16px;
            background: none;
            border: 1px solid #aaa;
            color: #aaa;
            border-radius: 3px;
            cursor: pointer;
        }

        .delete-confirm-proceed {
            padding: 8px 16px;
            background-color: #ff6b6b;
            border: none;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
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

        .hidden {
            display: none;
        }

        /* Media queries for responsive design */
        @media (max-width: 500px) {
            .review-card {
                flex-direction: column; /* Stack vertically on smaller screens */
            }
            
            .review-poster {
                width: 100px;
                margin-right: 0;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <?php require_once("../header.php")?>

    <main>
        <h1 class="page-title">My Reviews</h1>
        
        <div class="reviews-container">
            <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
                <div class="alert">Review successfully deleted.</div>
            <?php endif; ?>
            
            <?php if (!$is_logged_in): ?>
                <div class="login-required">
                    <h2>Please sign in to view your reviews</h2>
                    <p>Sign in to keep track of your movie reviews and ratings.</p>
                    <button class="login-btn start-reviewing">Sign In</button>
                </div>
            <?php elseif (empty($user_reviews)): ?>
                <div class="empty-reviews">
                    <h2>You haven't reviewed any movies yet</h2>
                    <p>Start rating and reviewing movies to keep track of your thoughts and opinions.</p>
                    <a href="index.php" class="start-reviewing">Discover Movies</a>
                </div>
            <?php else: ?>
                <?php foreach ($user_reviews as $review): ?>
                    <div class="review-card">
                        <img src="<?php echo htmlspecialchars($review['poster_path']); ?>" alt="<?php echo htmlspecialchars($review['title']); ?>" class="review-poster">
                        <div class="review-content">
                            <div class="review-header">
                                <h2 class="review-title"><?php echo htmlspecialchars($review['title']); ?></h2>
                            </div>
                            <div class="review-date"><?php echo formatDate($review['date_published']); ?></div>
                            <?php echo generateStarRating($review['note']); ?>
                            <div class="review-text"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></div>
                            <div class="review-actions">
                                <a href="../review/index.php?movie_id=<?php echo $review['movie_id']; ?>" class="edit-btn">Edit Review</a>
                                <button class="delete-btn" data-review-id="<?php echo $review['review_id']; ?>">Delete</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Delete confirmation dialog -->
        <div id="delete-confirm-dialog" class="delete-confirm-dialog">
            <div class="delete-confirm-content">
                <h3>Delete Review</h3>
                <p>Are you sure you want to delete this review? This action cannot be undone.</p>
                <div class="delete-confirm-actions">
                    <button id="delete-cancel" class="delete-confirm-cancel">Cancel</button>
                    <form id="delete-form" method="post" action="index.php" style="display: inline;">
                        <input type="hidden" name="review_id" id="review-id-to-delete">
                        <button type="submit" name="delete_review" class="delete-confirm-proceed">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php require_once("../footer.php");?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete confirmation dialog
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteDialog = document.getElementById('delete-confirm-dialog');
            const deleteForm = document.getElementById('delete-form');
            const deleteCancel = document.getElementById('delete-cancel');
            const reviewIdInput = document.getElementById('review-id-to-delete');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const reviewId = this.getAttribute('data-review-id');
                    reviewIdInput.value = reviewId;
                    deleteDialog.style.display = 'flex';
                });
            });
            
            deleteCancel.addEventListener('click', function() {
                deleteDialog.style.display = 'none';
            });
            
            // Close dialog when clicking outside
            deleteDialog.addEventListener('click', function(e) {
                if (e.target === deleteDialog) {
                    deleteDialog.style.display = 'none';
                }
            });
            
            // Login/Signup buttons functionality
            const loginButtons = document.querySelectorAll('.login-btn');
            loginButtons.forEach(button => {
                button.addEventListener('click', function() {
                    createAuthModal("login");
                });
            });
            
            const signupButtons = document.querySelectorAll('.signup-btn');
            signupButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Redirect to signup page or show signup modal
                    alert('Signup functionality would be implemented here');
                });
            });
            
            // Logout button functionality
            const logoutButton = document.querySelector('.logout-btn');
            if (logoutButton) {
                logoutButton.addEventListener('click', function() {
                    // Clear cookies and redirect
                    document.cookie = 'username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                    window.location.reload();
                });
            }
        });
    </script>
</body>
</html>