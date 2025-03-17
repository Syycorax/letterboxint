<?php
require_once('../functions.php');

// Database connection
$dsn = 'mysql:host=mysql;dbname=database';
$dbUser = 'user';
$dbPassword = 'password';
$page = "Friends";

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    require_once("../header.php");
    // Check if user is logged in
    if (!isset($_COOKIE['username'])) {?>
        <div class="reviews-container">
            <div class="login-required">
                <h2>Please sign in to view your friends</h2>
                <p>Sign in to keep track of your firendships</p>
                <button class="login-btn start-reviewing">Sign In</button>
            </div>
        </div>
        <?php
        require_once("../footer.php");
        exit();
    }
    
    $username = $_COOKIE['username'];
    $user_id = getUserIdByUsername($username, $pdo);
    
    // Handle friend requests
    if (isset($_POST['add_friend'])) {
        $friend_username = $_POST['friend_username'];
        
        // Get friend's user ID
        $sql = "SELECT user_id FROM user_account WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $friend_username]);
        $friend = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($friend) {
            $friend_id = $friend['user_id'];
            
            // Check if they're not already friends or have pending request
            $sql = "SELECT * FROM friendship 
                    WHERE (user_id_A = :user_id AND user_id_B = :friend_id) 
                    OR (user_id_A = :friend_id AND user_id_B = :user_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id, ':friend_id' => $friend_id]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$existing) {
                // Send friend request
                $sql = "INSERT INTO friendship (user_id_A, user_id_B, status, date_added) 
                        VALUES (:user_id, :friend_id, 'pending', CURDATE())";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':user_id' => $user_id, ':friend_id' => $friend_id]);
                $message = "Friend request sent to " . htmlspecialchars($friend_username);
            } else {
                $error = "You already have a friendship or pending request with this user";
            }
        } else {
            $error = "User not found";
        }
    }
    
    // Handle accepting friend requests
    if (isset($_POST['accept_request'])) {
        $friendship_id = $_POST['friendship_id'];
        
        $sql = "UPDATE friendship SET status = 'accepted' WHERE friendship_id = :friendship_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':friendship_id' => $friendship_id]);
        $message = "Friend request accepted";
    }
    
    // Handle rejecting friend requests
    if (isset($_POST['reject_request'])) {
        $friendship_id = $_POST['friendship_id'];
        
        $sql = "DELETE FROM friendship WHERE friendship_id = :friendship_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':friendship_id' => $friendship_id]);
        $message = "Friend request rejected";
    }
    
    // Handle removing friends
    if (isset($_POST['remove_friend'])) {
        $friendship_id = $_POST['friendship_id'];
        
        $sql = "DELETE FROM friendship WHERE friendship_id = :friendship_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':friendship_id' => $friendship_id]);
        $message = "Friend removed";
    }
    
    // Get friend requests for current user
    $sql = "SELECT f.friendship_id, u.username, u.user_id, f.date_added 
            FROM friendship f 
            JOIN user_account u ON f.user_id_A = u.user_id 
            WHERE f.user_id_B = :user_id AND f.status = 'pending'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $friend_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get current user's friends
    $sql = "SELECT f.friendship_id, u.username, u.user_id, f.date_added 
            FROM friendship f 
            JOIN user_account u ON (f.user_id_A = u.user_id OR f.user_id_B = u.user_id) 
            WHERE (f.user_id_A = :user_id OR f.user_id_B = :user_id) 
            AND u.user_id != :user_id 
            AND f.status = 'accepted'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get users who are not friends or have pending requests
    $sql = "SELECT u.username, u.user_id 
            FROM user_account u 
            WHERE u.user_id != :user_id 
            AND u.user_id NOT IN (
                SELECT IF(f.user_id_A = :user_id, f.user_id_B, f.user_id_A)
                FROM friendship f 
                WHERE (f.user_id_A = :user_id OR f.user_id_B = :user_id)
            )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $potential_friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get pending friend requests sent by current user
    $sql = "SELECT f.friendship_id, u.username, u.user_id, f.date_added 
            FROM friendship f 
            JOIN user_account u ON f.user_id_B = u.user_id 
            WHERE f.user_id_A = :user_id AND f.status = 'pending'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $pending_sent = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

require_once("../header.php");
?>

<main class="friends-page">
    <h1 class="page-title">Friends</h1>
    
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="friends-grid">
        <!-- Add Friend Section -->
        <div class="friends-section">
            <h2>Add a Friend</h2>
            <form class="add-friend-form" method="post" action="">
                <div class="form-group">
                    <input type="text" name="friend_username" placeholder="Enter username" required>
                    <button type="submit" name="add_friend" class="btn btn-primary">Send Request</button>
                </div>
            </form>
            
            <?php if (!empty($potential_friends)): ?>
                <div class="potential-friends">
                    <h3>Suggestions</h3>
                    <ul class="user-list">
                        <?php foreach ($potential_friends as $potential): ?>
                            <li>
                                <div class="user-card">
                                    <img src="https://api.dicebear.com/8.x/avataaars/svg?seed=<?php echo htmlspecialchars($potential['username']); ?>" alt="Avatar" class="avatar">
                                    <span class="username"><?php echo htmlspecialchars($potential['username']); ?></span>
                                    <form method="post" action="">
                                        <input type="hidden" name="friend_username" value="<?php echo htmlspecialchars($potential['username']); ?>">
                                        <button type="submit" name="add_friend" class="btn add-btn">Add</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Friend Requests Section -->
        <div class="friends-section">
            <h2>Friend Requests</h2>
            <?php if (empty($friend_requests)): ?>
                <p class="no-items">No pending friend requests</p>
            <?php else: ?>
                <ul class="user-list">
                    <?php foreach ($friend_requests as $request): ?>
                        <li>
                            <div class="user-card">
                                <img src="https://api.dicebear.com/8.x/avataaars/svg?seed=<?php echo htmlspecialchars($request['username']); ?>" alt="Avatar" class="avatar">
                                <span class="username"><?php echo htmlspecialchars($request['username']); ?></span>
                                <div class="friend-actions">
                                    <form method="post" action="">
                                        <input type="hidden" name="friendship_id" value="<?php echo $request['friendship_id']; ?>">
                                        <button type="submit" name="accept_request" class="btn btn-small btn-success">Accept</button>
                                        <button type="submit" name="reject_request" class="btn btn-small btn-danger">Reject</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
        <!-- Pending Sent Requests Section -->
        <div class="friends-section">
            <h2>Pending Sent Requests</h2>
            <?php if (empty($pending_sent)): ?>
                <p class="no-items">No pending sent requests</p>
            <?php else: ?>
                <ul class="user-list">
                    <?php foreach ($pending_sent as $pending): ?>
                        <li>
                            <div class="user-card">
                                <img src="https://api.dicebear.com/8.x/avataaars/svg?seed=<?php echo htmlspecialchars($pending['username']); ?>" alt="Avatar" class="avatar">
                                <span class="username"><?php echo htmlspecialchars($pending['username']); ?></span>
                                <span class="date-added">Sent on <?php echo date('M d, Y', strtotime($pending['date_added'])); ?></span>
                                <div class="friend-actions">
                                    <form method="post" action="">
                                        <input type="hidden" name="friendship_id" value="<?php echo $pending['friendship_id']; ?>">
                                        <button type="submit" name="reject_request" class="btn btn-small btn-danger">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
        <!-- Friends List Section -->
        <div class="friends-section friends-list">
            <h2>Your Friends</h2>
            <?php if (empty($friends)): ?>
                <p class="no-items">You don't have any friends yet</p>
            <?php else: ?>
                <ul class="user-list">
                    <?php foreach ($friends as $friend): ?>
                        <li>
                            <div class="user-card">
                                <img src="https://api.dicebear.com/8.x/avataaars/svg?seed=<?php echo htmlspecialchars($friend['username']); ?>" alt="Avatar" class="avatar">
                                <span class="username"><?php echo htmlspecialchars($friend['username']); ?></span>
                                <span class="date-added">Friends since <?php echo date('M d, Y', strtotime($friend['date_added'])); ?></span>
                                <div class="friend-actions">
                                    <!-- <a href="profile.php?user_id=<?php echo $friend['user_id']; ?>" class="btn btn-small">View Profile</a> -->
                                    <form method="post" action="">
                                        <input type="hidden" name="friendship_id" value="<?php echo $friend['friendship_id']; ?>">
                                        <button type="submit" name="remove_friend" class="btn btn-small btn-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once("../footer.php"); ?>