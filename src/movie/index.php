<?php
require_once('../functions.php');

// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'utilisateur';
$dbPassword = 'password';
$page = "Movie";

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
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



    // Check if movie_id is provided in URL
    if (!isset($_GET['movie_id'])) {
        // Show all movies in the database
        
        // Fetch all movies
        $sql = "SELECT * FROM movie";
        $stmt = $pdo->query($sql);
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once("../header.php");


        ?>
        <main>
            <section class="watchlist">
                <h2>All movies</h2>
                <div class="film-grid" id="watchlist">
                    <?php
                    if (!empty($movies)) {
                        foreach ($movies as $movie) {
                            echo createMovieCard($movie, $pdo);
                        }
                    } else {
                        echo "No movies found in the database. *panic*";
                    }
                    ?>
                </div>
            </section>
        </main>
        <?php

    } else {
    
        $movie_id = $_GET['movie_id'];
        
        // Fetch movie details
        $sql = "SELECT * FROM movie WHERE movie_id = :movie_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':movie_id' => $movie_id]);
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$movie) {
            // Movie not found
            header("Location: index.php");
            exit();
        }
        
        // Fetch directors
        $sql = "SELECT d.* FROM director d 
                JOIN director_association da ON d.director_id = da.director_id 
                WHERE da.movie_id = :movie_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':movie_id' => $movie_id]);
        $directors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Fetch actors and their roles
        $sql = "SELECT a.*, c.role FROM actor a 
                JOIN casting c ON a.actor_id = c.actor_id 
                WHERE c.movie_id = :movie_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':movie_id' => $movie_id]);
        $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Fetch genres
        $sql = "SELECT g.* FROM genre g 
                JOIN genre_association ga ON g.genre_id = ga.genre_id 
                WHERE ga.movie_id = :movie_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':movie_id' => $movie_id]);
        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Fetch reviews
        $sql = "SELECT r.*, u.username FROM review r 
                JOIN user_account u ON r.user_id = u.user_id 
                WHERE r.movie_id = :movie_id 
                ORDER BY r.date_published DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':movie_id' => $movie_id]);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate average rating
        $sql = "SELECT AVG(note) as avg_rating FROM review WHERE movie_id = :movie_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':movie_id' => $movie_id]);
        $avgRating = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if movie is in user's watchlist (if user is logged in)
        $watchlistStatus = null;
        if (isset($_COOKIE['username'])) {
            $user = $_COOKIE['username'];
            $user_id = getUserIdByUsername($user, $pdo);
            $sql = "SELECT status FROM watchlist WHERE user_id = :user_id AND movie_id = :movie_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id, ':movie_id' => $movie_id]);
            $watchlistResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $watchlistStatus = $watchlistResult ? $watchlistResult['status'] : null;
        }

        // Handle watchlist button actions
        if (isset($_POST['watch'])) {
            if (!isset($_COOKIE['username'])) {
                // Redirect to login if not logged in
                header("Location: login.php");
                exit();
            }

            $user = $_COOKIE['username'];
            $user_id = getUserIdByUsername($user, $pdo);
            
            if (isset($_POST['remove'])) {
                // Remove from watchlist
                $sql = "DELETE FROM watchlist WHERE user_id = :user_id AND movie_id = :movie_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':user_id' => $user_id, ':movie_id' => $movie_id]);
            } elseif (isset($_POST['mark_as_seen'])) {
                // Update to seen
                $status = "seen";
                if ($watchlistStatus) {
                    $sql = "UPDATE watchlist SET status = :status WHERE user_id = :user_id AND movie_id = :movie_id";
                } else {
                    $sql = "INSERT INTO watchlist (user_id, status, movie_id) VALUES (:user_id, :status, :movie_id)";
                }
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':user_id' => $user_id, ':status' => $status, ':movie_id' => $movie_id]);
            } else {
                // Add to watchlist
                $status = "to_watch";
                if ($watchlistStatus) {
                    $sql = "UPDATE watchlist SET status = :status WHERE user_id = :user_id AND movie_id = :movie_id";
                } else {
                    $sql = "INSERT INTO watchlist (user_id, status, movie_id) VALUES (:user_id, :status, :movie_id)";
                }
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':user_id' => $user_id, ':status' => $status, ':movie_id' => $movie_id]);
            }
            
            // Refresh the page
            header("Location: index.php?movie_id=" . $movie_id);
            exit();
        }

        require_once("../header.php");
        ?>


        <main class="movie-details">
            <div class="movie-header">
                <div class="movie-poster">
                    <?php if ($movie['poster_path']): ?>
                        <img src="<?php echo htmlspecialchars($movie['poster_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?> poster">
                    <?php else: ?>
                        <div class="no-poster">No poster available</div>
                    <?php endif; ?>
                </div>
                
                <div class="movie-info">
                    <h1><?php echo htmlspecialchars($movie['title']); ?> <span class="year">(<?php echo htmlspecialchars($movie['year_released']); ?>)</span></h1>
                    
                    <?php if (!empty($genres)): ?>
                        <div class="genres">
                            <?php foreach ($genres as $genre): ?>
                                <span class="genre-tag"><?php echo htmlspecialchars($genre['name']); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($avgRating['avg_rating']): ?>
                        <div class="rating">
                            <span class="star">★</span> <?php echo number_format($avgRating['avg_rating'], 1); ?>/5
                            <span class="reviews-count">(<?php echo count($reviews); ?> reviews)</span>
                        </div>
                    <?php else: ?>
                        <div class="rating">No ratings yet</div>
                    <?php endif; ?>
                    
                    <div class="runtime">
                        <?php echo intdiv($movie['running_time'], 60) . 'h ' . ($movie['running_time'] % 60) . 'min'; ?>
                    </div>
                    
                    <div class="actions">
                        <form method="post" action="">
                            <?php if ($watchlistStatus === 'to_watch'): ?>
                                <input type="hidden" name="mark_as_seen" value="yes">
                                <button type="submit" name="watch" class="btn">Mark as seen</button>
                                <input type="hidden" name="remove" value="yes">
                                <button type="submit" name="watch" class="btn watchlist-btn">Remove from watchlist</button>
                            <?php elseif ($watchlistStatus === 'seen'): ?>
                                <button disabled class="btn watchlist-btn">Seen</button>
                                <input type="hidden" name="remove" value="yes">
                                <button type="submit" name="watch" class="btn watchlist-btn">Remove from watched</button>
                            <?php else: ?>
                                <button type="submit" name="watch" class="btn watchlist-btn">Add to watchlist</button>
                                <input type="hidden" name="mark_as_seen" value="yes">
                                <button type="submit" name="watch" class="btn">Mark as seen</button>
                            <?php endif; ?>
                        </form>
                        <a href="/review?movie_id=<?php echo $movie_id; ?>" class="btn watchlist-btn">Write a review</a>
                    </div>
                    
                                    <input type="hidden" name="remove" value="yes">
                        <h3>Synopsis</h3>
                        <p><?php echo htmlspecialchars($movie['synopsis']); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="movie-details-grid">
                <div class="directors">
                    <h3>Director<?php echo count($directors) > 1 ? 's' : ''; ?></h3>
                    <ul class="people-list">
                        <?php foreach ($directors as $director): ?>
                            <li>
                                <div class="name"><?php echo htmlspecialchars($director['name']); ?></div>
                                <div class="details">
                                    <?php if ($director['birthdate']): ?>
                                        <span class="birth"><?php echo date('Y', strtotime($director['birthdate'])); ?></span>
                                    <?php endif; ?>
                                    <?php if ($director['nationality']): ?>
                                        <span class="nationality"><?php echo htmlspecialchars($director['nationality']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="cast">
                    <h3>Cast</h3>
                    <ul class="people-list">
                        <?php foreach ($actors as $actor): ?>
                            <li>
                                <div class="name"><?php echo htmlspecialchars($actor['name']); ?></div>
                                <?php if ($actor['role']): ?>
                                    <div class="role">as <?php echo htmlspecialchars($actor['role']); ?></div>
                                <?php endif; ?>
                                <div class="details">
                                    <?php if ($actor['birthdate']): ?>
                                        <span class="birth"><?php echo date('Y', strtotime($actor['birthdate'])); ?></span>
                                    <?php endif; ?>
                                    <?php if ($actor['nationality']): ?>
                                        <span class="nationality"><?php echo htmlspecialchars($actor['nationality']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <div class="reviews-section">
                <h2>Reviews</h2>
                <?php if (empty($reviews)): ?>
                    <p class="no-reviews">No reviews yet. Be the first to review!</p>
                <?php else: ?>
                    <div class="reviews-list">
                        <?php foreach ($reviews as $review): ?>
                            <div class="review">
                                <div class="review-header">
                                    <span class="reviewer"><?php echo htmlspecialchars($review['username']); ?></span>
                                    <span class="review-date"><?php echo date('M d, Y', strtotime($review['date_published'])); ?></span>
                                    <span class="review-rating">
                                        <span class="star">★</span> <?php echo number_format($review['note'], 1); ?>/5
                                    </span>
                                </div>
                                <div class="review-body">
                                    <?php echo htmlspecialchars($review['comment']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="write-review">
                    <a href="/review?movie_id=<?php echo $movie_id; ?>" class="btn btn-primary">Write a review</a>
                </div>
            </div>
        </main>

        <?php
    }

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>

<?php require_once("../footer.php"); ?>