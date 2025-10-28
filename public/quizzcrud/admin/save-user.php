<?php
require_once __DIR__ . '/auth-check.php';
require_once __DIR__ . '/../../../private_quizzcrud/includes/db_setup.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $password = $_POST['password'];
    $current_user_id = $_SESSION['user_id'];

    $db = get_db_connection();

    if (empty($user_id)) { // Create new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashed_password, $role]);
    } else { // Update existing user
        // Prevent admin from changing their own role
        if ($user_id == $current_user_id) {
            $role = 'admin'; // Force role to admin
        }

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $hashed_password, $role, $user_id]);
        } else {
            $stmt = $db->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $role, $user_id]);
        }

        // Si l'utilisateur mis à jour est l'utilisateur actuel, mettez à jour la session
        if (isset($_SESSION['user_id']) && $user_id == $_SESSION['user_id']) {
            $_SESSION['username'] = $username;
        }
    }

    header('Location: users.php?status=success');
    exit;
}
