<?php
require_once __DIR__ . '/auth-check.php';
require_once __DIR__ . '/../../../private_quizzcrud/includes/db_setup.php';

if (isset($_GET['user_id'])) {
    $user_id_to_delete = $_GET['user_id'];
    $current_user_id = $_SESSION['user_id'];

    if ($user_id_to_delete == $current_user_id) {
        header('Location: users.php?status=error_self_delete');
        exit;
    }

    $db = get_db_connection();
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id_to_delete]);
}

header('Location: users.php?status=deleted');
exit;
