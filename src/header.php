<?php
// get the page variable from caller's code
require_once("functions.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LetterboxINT</title>
    <link rel="stylesheet" href="/style.css">
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
                <a href="/" class="<?= $page === 'Films' ? 'active' : '' ?>">Films</a>
                <a href="/watchlist" class="<?= $page === 'Watchlist' ? 'active' : '' ?>">Watchlist</a>
                <a href="/friends" class="<?= $page === 'Friends' ? 'active' : '' ?>">Friends</a>
                <a href="/reviews" class="<?= $page === 'Reviews' ? 'active' : '' ?>">Reviews</a>
                <a href="/movie" class="<?= $page === 'Movie' ? 'active' : '' ?>">Movie</a>
            </div>
            <div class="spacer"></div>
            <div class="user-actions">
                <!-- <input type="search" placeholder="Search movies, lists, people..."> -->
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