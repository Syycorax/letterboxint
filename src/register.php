<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Simple database connection
        $dsn = 'mysql:host=mysql;dbname=database';
        $dbUser = 'utilisateur';
        $dbPassword = 'password';

        try {
            // Create PDO connection
            $pdo = new PDO($dsn, $dbUser, $dbPassword);
            $stmt = $pdo->prepare('INSERT INTO user_account (username, email, password, date_joined) VALUES (:username, :email, :password, :date)');
            
            // Execute the statement
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $password,
                ':date' => date('Y-m-d H:i:s')
            ]);
            setcookie('username', $username, [
                'expires' => time() + 3600,
                'path' => '/',
                'domain' => 'localhost',
                'secure' => false,
                'httponly' => false,
                'samesite' => 'Lax'
            ]);
            // Simple success response
            echo json_encode([
                'success' => true,
                'message' => 'User registered successfully!'
            ]);
        } catch (PDOException $e) {
            // Simple error handling
            echo json_encode([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ]);
            // set cookie to username
            setcookie('username', $username, time() + 3600, '/');
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Please fill in all fields.'
        ]);
    }
}
?>