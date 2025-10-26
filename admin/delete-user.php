<?php
require_once 'auth-check.php';
require_once '../includes/db_setup.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $db = get_db_connection();
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
}

header('Location: users.php?status=deleted');
exit;
