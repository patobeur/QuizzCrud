<?php
// This script is intended to be included by auth-check.php

// The session is already started in auth-check.php
// The user's existence is already verified in auth-check.php

$db_check = get_db_connection();
$stmt_check = $db_check->prepare("SELECT password_reset_required FROM users WHERE id = ?");
$stmt_check->execute([$_SESSION['user_id']]);
$user_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

if ($user_check && $user_check['password_reset_required'] == 1) {
    // Redirect to the password reset page if the current page isn't already the reset page
    if (basename($_SERVER['PHP_SELF']) !== 'force_password_reset.php') {
        header('Location: /quizzcrud/admin/force_password_reset.php');
        exit;
    }
}
