<?php
function getUserIdByUsername($username, $pdo) {
    $sql = "SELECT user_id FROM user_account WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['user_id'] : null;
}
?>