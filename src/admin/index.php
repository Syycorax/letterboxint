<?php
require_once('../functions.php');

$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'utilisateur';
$dbPassword = 'password';

try {
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if user is admin
if (isset($_COOKIE["username"]) && isAdmin($_COOKIE["username"], $pdo)) {
    $user = $_COOKIE["username"];
} else {
    header("Location: /");
    exit();
}

// Use admin credentials for database operations
$dbuser = "admin";
$dbpass = "adminpassword";
try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle delete user request
if (isset($_POST['delete_user'])) {
    $userId = $_POST['user_id'];
    $sql = "DELETE FROM user_account WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    
    header("Location: /admin/index.php?message=User+deleted");
    exit();
}

// Handle delete movie request
if (isset($_POST['delete_movie'])) {
    $movieId = $_POST['movie_id'];
    $sql = "DELETE FROM movie WHERE movie_id = :movie_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':movie_id' => $movieId]);
    
    header("Location: /admin/index.php?message=Movie+deleted");
    exit();
}

// Get all users
$usersql = "SELECT user_id, username FROM user_account";
$userstmt = $pdo->query($usersql);
$users = $userstmt->fetchAll(PDO::FETCH_ASSOC);

// Get all movies
$moviesql = "SELECT movie_id, title FROM movie";
$moviestmt = $pdo->query($moviesql);
$movies = $moviestmt->fetchAll(PDO::FETCH_ASSOC);

$page = "Admin";
require_once("../header.php");
?>

<main class="admin-panel">
    <h1>Admin Management Panel</h1>
    
    <?php if (isset($_GET['message'])): ?>
        <div class="message"><?php echo $_GET['message']; ?></div>
    <?php endif; ?>
    
    <section class="admin-section">
        <h2>Manage Users</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user):
                    if ($user["username"]){?>
                <tr>
                    <td><?php echo $user['username']; ?></td>
                    <td>
                        <form method="post" action="/admin/index.php" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <button type="submit" name="delete_user" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php }endforeach; ?>
            </tbody>
        </table>
    </section>
    
    <section class="admin-section">
        <h2>Manage Movies</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?php echo $movie['title']; ?></td>
                    <td>
                        <form method="post" action="/admin/index.php" onsubmit="return confirm('Are you sure you want to delete this movie?');">
                            <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                            <button type="submit" name="delete_movie" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<style>
    .admin-panel {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .admin-section {
        margin-bottom: 40px;
    }
    
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    
    .admin-table th, .admin-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    .delete-btn {
        background-color: #ff4d4d;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 3px;
    }
    
    .delete-btn:hover {
        background-color: #ff1a1a;
    }
    
    .message {
        background-color: #f0f0f0;
        padding: 10px;
        margin-bottom: 20px;
        border-left: 5px solid #4CAF50;
    }
</style>

<?php require_once("../footer.php"); ?>