<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if username and password are provided
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';


        try {
            // Database connection 
            $db = new PDO('mysql:host=mysql;dbname=database', 'user', 'password');

            // Prepare statement to fetch user
            $stmt = $db->prepare('SELECT * FROM user_account WHERE email = :email LIMIT 1');
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $username = $user['username'];

            // Simple password check
            if ($user && $password === $user['password']) {
                // Successful login
                setcookie('username', $username, [
                'expires' => time() + 3600,
                'path' => '/',
                'domain' => 'localhost',
                'secure' => false,
                'httponly' => false,
                'samesite' => 'Lax'
            ]);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Login successful!',
                    'redirect' => '/profile'
                ]);
            } else {
                // Failed login
                echo json_encode([
                    'success' => false, 
                    'message' => 'Invalid username or password.'
                ]);
            }
        } catch (PDOException $e) {
            // Database error handling
            echo json_encode([
                'success' => false, 
                'message' => 'Login failed: ' . $e->getMessage()
            ]);
        }
    } else {
        // Missing credentials
        echo json_encode([
            'success' => false, 
            'message' => 'Please provide username and password.'
        ]);
    }
} else {
    // Invalid request method
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid request method.'
    ]);
}
?>