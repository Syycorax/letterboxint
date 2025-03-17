<?php
// get the page variable from caller's code
require_once("functions.php");
if (isset($_COOKIE['username'])) {
    $user = $_COOKIE['username'];
} else {
    $user = null;
}
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';
try {
    // Create PDO connection
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LetterboxINT</title>
    <link rel="stylesheet" href="/style.css">
    <script src="/all.js"></script>
    <style>
        /* Add custom styles for the header */
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
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">LetterboxINT</div>
            <div class="nav-links">
                <a href="/" class="<?= $page === 'Home' ? 'active' : '' ?>">Home</a>
                <a href="/watchlist" class="<?= $page === 'Watchlist' ? 'active' : '' ?>">Watchlist</a>
                <a href="/friends" class="<?= $page === 'Friends' ? 'active' : '' ?>">Friends</a>
                <a href="/reviews" class="<?= $page === 'Reviews' ? 'active' : '' ?>">Reviews</a>
                <a href="/movie" class="<?= $page === 'Movie' ? 'active' : '' ?>">Movie</a>
                <?php if (isAdmin($user, $pdo)): ?>
                    <a href="/admin" class="<?= $page === 'Admin' ? 'active' : '' ?>">Admin</a>
                <?php endif; ?>
            </div>
            <div class="spacer"></div>
            <div class="user-actions">
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