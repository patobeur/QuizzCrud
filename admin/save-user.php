<?php
require_once 'auth-check.php';
require_once '../includes/db_setup.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    $db = get_db_connection();

    if (empty($user_id)) { // Create new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashed_password, $role]);
    } else { // Update existing user
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $hashed_password, $role, $user_id]);
        } else {
            $stmt = $db->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $role, $user_id]);
        }
    }

    header('Location: users.php?status=success');
    exit;
}
