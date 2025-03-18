<?php
function getUserIdByUsername($username, $pdo) {
    $sql = "SELECT user_id FROM user_account WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['user_id'] : null;
}

function createMovieCard($movie, $pdo) {
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

    $html = '<div class="film-card">';
    $html .= '<a href="/movie?movie_id=' . $movie["movie_id"] . '">';
    $html .= '<img src="' . $movie["poster_path"] . '" alt="' . $movie["title"] . '">';
    $html .= '</a>';
    $html .= '<h3><a href="/movie?movie_id=' . $movie["movie_id"] . '">' . $movie["title"] . '</a></h3>';
    $html .= '<form class="button-form" method="post" action="index.php">';
    if ($film_in_user_watchlist) {
        $html .= '<input type="hidden" name="remove" value="yes">';
        $html .= '<input type="hidden" name="movie_id" value="' . $movie["movie_id"] . '">';
        $html .= '<button type="submit" name="watch" class="watchlist-btn">Mark as seen</button>';
    } elseif ($film_seen) {
        // Do nothing if the film is already seen
    } else {
        $html .= '<input type="hidden" name="movie_id" value="' . $movie["movie_id"] . '">';
        $html .= '<button type="submit" name="watch" class="watchlist-btn">add to watchlist</button>';
    }
    $html .= '</form>';
    $html .= '<a href="/review?movie_id=' . $movie["movie_id"] . '" class="rating-btn" name="' . $movie["title"] . '">Add review</a>';
    $html .= '</div>';

    return $html;
}

function isAdmin($user, $pdo) {
    $sql = "SELECT is_admin FROM user_account WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $user]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['is_admin'] : false;
}
?>